<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bill_payee_id',
        'account_id',
        'payee_name',
        'payee_type',
        'account_number',
        'provider',
        'amount',
        'reference_number',
        'status',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payee()
    {
        return $this->belongsTo(BillPayee::class, 'bill_payee_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
