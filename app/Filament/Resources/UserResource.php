<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Client; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model; 
use Filament\Forms\Components\Tabs; 

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Configuracion';
    protected static ?int $navigationSort = 55;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('business_id') 
                    ->default(auth()->user()->business_id),
                
                Forms\Components\TextInput::make('name')
                    ->label('Nombre de usuario')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('email')
                    ->label('Correo')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                
                Forms\Components\Select::make('client_id')
                    ->label('Cliente Asociado (Solo B2B)')
                    ->options(Client::query()->pluck('name', 'id')) 
                    ->placeholder('N/A (Usuario Admin o Vendedor)')
                    ->nullable()
                    ->searchable()
                    ->visible(fn ($record) => $record?->business_id === null),

                Forms\Components\Select::make('estado')
                    ->label('Estado de Acceso General')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'pendiente' => 'Pendiente de Revisión',
                    ])
                    ->default('activo')
                    ->required(),
                
                Forms\Components\TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrated(fn ($state) => filled($state)) 
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                
                Forms\Components\Select::make('roles')
                    ->label('Asignar role')
                    ->relationship(
                        name: 'roles',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('name', '!=', 'super-admin')
                    )
                    ->preload()
                    ->searchable(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre de usuario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'activo' => 'success',
                        'inactivo' => 'danger',
                        'pendiente' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creacion')
                    ->dateTime('d-M-Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Filtrar por Estado')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'pendiente' => 'Pendiente',
                    ]),
                Tables\Filters\SelectFilter::make('roles')
                    ->label('Filtrar por Rol')
                    ->relationship('roles', 'name', fn (Builder $query) => $query->where('name', '!=', 'super-admin'))
                    ->preload(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()
                 ->visible(fn ($record) => !$record->hasRole('super-admin')),
                Tables\Actions\DeleteAction::make()
                 ->visible(fn ($record) => !$record->hasRole('super-admin')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        // Filtro base: Solo usuarios de este negocio
        return parent::getEloquentQuery(); //->where('business_id', auth()->user()->business_id);
    }
    
    public static function creating(Model $model): void
    {
        $model->business_id = auth()->user()->business_id;
    }
}