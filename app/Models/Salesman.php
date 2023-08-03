<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Salesman extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'email',
        'born_date',
    ];

    protected $hidden = [
        'client_id',
    ];

    /**
     * Eloquent Relationships
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function sales() : HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
