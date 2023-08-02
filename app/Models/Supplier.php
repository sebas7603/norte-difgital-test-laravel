<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'rut',
        'name',
        'address_street',
        'address_number',
        'address_commune',
        'address_city',
        'phone',
        'webpage',
    ];

    /**
     * Eloquent Relationships
     */
    public function products(): HasMany
    {
        return $this->belongsTo(Product::class);
    }
}
