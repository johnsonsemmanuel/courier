<?php

namespace App\Policies;

use App\Models\BillPayment;
use App\Models\User;

class BillPaymentPolicy
{
    public function view(User $user, BillPayment $payment): bool
    {
        return $user->id === $payment->user_id;
    }
}
