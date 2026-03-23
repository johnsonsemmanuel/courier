<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxAlert extends Model
{
    protected $fillable = [
        'user_id',
        'has_tax_obligation',
        'tax_amount',
        'notes',
    ];

    protected $casts = [
        'has_tax_obligation' => 'boolean',
        'tax_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
