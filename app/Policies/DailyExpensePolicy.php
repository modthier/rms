<?php

namespace App\Policies;

use App\Models\DailyExpense;
use App\Models\User;

class DailyExpensePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function view(User $user, DailyExpense $dailyExpense): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function update(User $user, DailyExpense $dailyExpense): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function delete(User $user, DailyExpense $dailyExpense): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }
}

