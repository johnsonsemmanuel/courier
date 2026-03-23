<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'card_number',
        'card_holder_name',
        'cvv',
        'expiry_month',
        'expiry_year',
        'card_type',
        'card_brand',
        'status',
        'daily_limit',
        'monthly_limit',
        'daily_spent',
        'monthly_spent',
        'last_reset_at',
    ];

    protected $casts = [
        'daily_limit' => 'decimal:2',
        'monthly_limit' => 'decimal:2',
        'daily_spent' => 'decimal:2',
        'monthly_spent' => 'decimal:2',
        'last_reset_at' => 'datetime',
    ];

    protected $hidden = [
        'cvv',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function isFrozen(): bool
    {
        return $this->status === 'frozen';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getMaskedCardNumberAttribute(): string
    {
        return '**** **** **** ' . substr($this->card_number, -4);
    }

    public function getFormattedCardNumberAttribute(): string
    {
        return chunk_split($this->card_number, 4, ' ');
    }
}
