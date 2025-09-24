<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Sale;
use App\Models\Zone;
use App\Models\Location; 
use App\Models\Inventory;
use App\Models\Product; 
use Barryvdh\DomPDF\Facade\Pdf;

use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;

class SaleResource extends Resource
{
    // Usamos el nombre de clase completamente calificado para evitar ambigüedades.
    protected static ?string $model = \App\Models\Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Operaciones';
    protected static ?int $navigationSort = 11;

    protected static ?string $modelLabel = 'Venta';
    protected static ?string $pluralModelLabel = 'Ventas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // CAMBIO: Se re-introduce el Wizard
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Cliente y Fecha')
                        ->schema([
                            Forms\Components\Hidden::make('business_id')->default(auth()->user()->business_id),
                            Forms\Components\Select::make('client_id')
                                ->label('Cliente')
                                ->options(\App\Models\Client::query()->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->required()
                                // CAMBIO: Se añade la capacidad de crear un cliente al vuelo
                                ->createOptionForm([
                                    Forms\Components\Hidden::make('business_id')->default(auth()->user()->business_id),
                                    Forms\Components\TextInput::make('name')->label('Nombre del Cliente')->required(),
                                    Forms\Components\TextInput::make('document')->label('Documento'),
                                    Forms\Components\TextInput::make('phone')->label('Teléfono'),
                                    Forms\Components\Select::make('zone_id')
                                    ->label('Zona')
                                    ->options(Zone::query()->where('business_id', auth()->user()->business_id)->pluck('name', 'id'))
                                    ->searchable()
                                    ->placeholder('Sin zona asignada'),
                                ])->createOptionUsing(function (array $data): int {
                                    return \App\Models\Client::create($data)->id;
                                }),
                            Forms\Components\DatePicker::make('date')->label('Fecha de la Venta')->required()->default(now()),
                            Forms\Components\Select::make('location_id')
                            ->label('Vender desde Bodega / Sucursal')
                            ->options(Location::query()->pluck('name', 'id'))
                            ->required()
                            ->live() // Para que el stock se actualice dinámicamente
                            ->helperText('El stock de los productos se descontará de esta ubicación.'),
                        
                            Forms\Components\Toggle::make('is_cash')
                                ->label('Venta de Contado')
                                ->default(false),
                                //->live(),    
                        ]),

                    Forms\Components\Wizard\Step::make('Items de la Venta')
                        ->schema([
                            Forms\Components\Repeater::make('items')
                                ->schema([
                                    Forms\Components\Select::make('product_id')
                                    ->label('Producto')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    // Este método le dice a Filament cómo buscar productos cuando el usuario escribe
                                    ->getSearchResultsUsing(function (string $search) {
                                        return \App\Models\Product::where('name', 'like', "%{$search}%")
                                            ->limit(50)
                                            ->pluck('name', 'id');
                                    })
                                    // Este método le dice a Filament cómo obtener el nombre de un producto que ya está seleccionado
                                    ->getOptionLabelUsing(function ($value): ?string {
                                        return \App\Models\Product::find($value)?->name;
                                    })
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $product = \App\Models\Product::find($get('product_id'));
                                        if ($product) {
                                            $set('price', $product->price ?? 0);
                                            $locationId = $get('../../location_id'); 
                                            if ($locationId) {
                                                $inventory = \App\Models\Inventory::where('product_id', $product->id)
                                                    ->where('location_id', $locationId)->first();
                                                $stock = $inventory ? $inventory->stock : 0;
                                                $set('stock_info', "{$stock}");
                                            } else {
                                                $set('stock_info', "Selecciona una bodega para ver el stock.");
                                            }
                                        }
                                    }),
                                    Forms\Components\TextInput::make('stock_info')->label('Stock Actual')->readOnly(),
                                    Forms\Components\TextInput::make('quantity')->label('Cantidad')->required()->numeric()->live(onBlur: true),
                                    Forms\Components\Select::make('unit_of_measure_id')->label('Unidad de Venta')->options(\App\Models\UnitOfMeasure::query()->pluck('name', 'id'))->searchable()->preload()->required(),
                                    Forms\Components\TextInput::make('price')->label('Precio (antes de IVA)')->required()->numeric()->live(onBlur: true),
                                    Forms\Components\TextInput::make('tax_rate')->label('IVA (%)')->numeric()->required()->default(19)->live(onBlur: true),
                                ])
                                ->columns(6)
                                ->live()
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set)),
                        ]),

                    Forms\Components\Wizard\Step::make('Resumen de Totales')
                        ->schema([
                            Forms\Components\TextInput::make('subtotal')->label('Subtotal')->readOnly()->numeric()->prefix('$'),
                            Forms\Components\TextInput::make('tax')->label('Total IVA')->readOnly()->numeric()->prefix('$'),
                            Forms\Components\TextInput::make('total')->label('Total General')->readOnly()->numeric()->prefix('$'),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
            ->label('N° Venta')
            ->sortable(),
            Tables\Columns\TextColumn::make('client.name')
            ->label('Cliente')
            ->searchable(),
            Tables\Columns\TextColumn::make('location.name')
            ->label('Bodega/Sucursal')
            ->searchable(),
            Tables\Columns\TextColumn::make('subtotal')
            ->money('cop')->sortable(),
            Tables\Columns\TextColumn::make('tax')
            ->label('Iva')
            ->money('cop')->sortable(),   
            Tables\Columns\TextColumn::make('total')
            ->money('cop')->sortable(), 
            Tables\Columns\TextColumn::make('date')
            ->date('d/m/Y')
            ->label('Fecha'),
            Tables\Columns\IconColumn::make('is_cash')
                ->label('Condición')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->trueColor('success')
                ->falseIcon('heroicon-o-clock')
                ->falseColor('warning')
                ->getStateUsing(fn (Sale $record): bool => $record->is_cash)
                ->tooltip(fn (Sale $record): string => $record->is_cash ? 'Contado' : 'Crédito'),
            Tables\Columns\TextColumn::make('status')
                ->label('Estado')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Pagada' => 'success',
                    'Pendiente' => 'warning',
                    'Vencida' => 'danger',
                    default => 'gray',
                }),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                // <<< AÑADIMOS LOS FILTROS AQUÍ >>>
                SelectFilter::make('client_id')
                    ->label('Cliente')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('zone')
                    ->label('Zona')
                    ->relationship('client.zone', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('date')
                    ->form([
                        DatePicker::make('start_date')->label('Fecha Inicio'),
                        DatePicker::make('end_date')->label('Fecha Fin'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['end_date'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('printReceipt')
                        ->label('Imprimir Tirilla')
                        ->icon('heroicon-o-printer')
                        ->url(fn (Sale $record): string => route('sales.receipt.print', $record))
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('downloadInvoice')
                        ->label('Descargar Factura PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (Sale $record) {
                            $sale = $record->load(['client', 'business', 'items.product.unitOfMeasure', 'items.unitOfMeasure']);
                            $pdf = Pdf::loadView('pdf.invoice', ['sale' => $sale]);
                            return response()->streamDownload(fn() => print($pdf->output()), "factura-{$sale->id}.pdf");
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
            'view' => Pages\ViewSale::route('/{record}'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('business_id', auth()->user()->business_id);
    }
    
    public static function updateTotals(Get $get, Set $set): void
    {
        $items = $get('items') ?? [];
        $subtotal = 0;
        $taxTotal = 0;

        // CAMBIO: Se vuelve a calcular el subtotal y el IVA por separado
        foreach ($items as $item) {
            $itemSubtotal = (float)($item['quantity'] ?? 0) * (float)($item['price'] ?? 0);
            $subtotal += $itemSubtotal;
            $taxTotal += $itemSubtotal * ((float)($item['tax_rate'] ?? 0) / 100);
        }
        
        $set('subtotal', $subtotal);
        $set('tax', $taxTotal);
        $set('total', $subtotal + $taxTotal);
    }
}


