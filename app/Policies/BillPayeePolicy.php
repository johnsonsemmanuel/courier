<?php

namespace App\Policies;

use App\Models\BillPayee;
use App\Models\User;

class BillPayeePolicy
{
    public function view(User $user, BillPayee $payee): bool
    {
        return $user->id === $payee->user_id;
    }

    public function update(User $user, BillPayee $payee): bool
    {
        return $user->id === $payee->user_id;
    }

    public function delete(User $user, BillPayee $payee): bool
    {
        return $user->id === $payee->user_id;
    }
}
