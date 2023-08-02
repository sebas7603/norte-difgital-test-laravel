<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'money_code',
        'money_symbol',
    ];

    /**
     * Eloquent Relationships
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('stock', 'price');
    }

    public function sales() : HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
