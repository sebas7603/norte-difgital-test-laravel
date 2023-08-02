<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
