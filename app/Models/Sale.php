<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'salesman_id',
        'client_id',
        'branch_id',
        'total',
    ];

    protected $hidden = [
        'salesman_id',
        'client_id',
        'branch_id',
    ];

    /**
     * Eloquent Relationships
     */
    public function salesman(): BelongsTo
    {
        return $this->belongsTo(Salesman::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'sales_items')->withPivot('price', 'quantity', 'subtotal');
    }
}
