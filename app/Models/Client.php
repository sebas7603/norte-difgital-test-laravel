<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'rut',
        'name',
        'lastname',
        'address_street',
        'address_number',
        'address_commune',
        'address_city',
        'phone',
    ];

    /**
     * Eloquent Relationships
     */
    public function salesman(): HasOne
    {
        return $this->hasOne(Salesman::class);
    }

    public function purchases() : HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
