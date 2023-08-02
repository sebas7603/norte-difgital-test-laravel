<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salesman extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'email',
        'born_date',
    ];

    /**
     * Eloquent Relationships
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
