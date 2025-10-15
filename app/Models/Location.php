<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'name',
        'is_primary',
        'address',
        'is_b2b_warehouse',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_b2b_warehouse' => 'boolean',
    ];

    /**
     * Una bodega pertenece a un negocio.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Una bodega tiene muchos productos a través de la tabla de inventario.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'inventory')
            ->withPivot('stock')
            ->withTimestamps();
    }
}
