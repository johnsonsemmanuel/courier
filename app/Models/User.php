<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'phone', 'address', 'user_id', 'two_factor_enabled', 'two_factor_code', 'two_factor_expires_at', 'is_admin'])]
#[Hidden(['password', 'remember_token', 'two_factor_code'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'two_factor_expires_at' => 'datetime',
            'is_admin' => 'boolean',
        ];
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Account::class);
    }

    public function kycVerification()
    {
        return $this->hasOne(KycVerification::class);
    }

    public function taxAlert()
    {
        return $this->hasOne(TaxAlert::class);
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function recurringTransfers()
    {
        return $this->hasMany(RecurringTransfer::class);
    }

    public function billPayees()
    {
        return $this->hasMany(BillPayee::class);
    }

    public function billPayments()
    {
        return $this->hasMany(BillPayment::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
