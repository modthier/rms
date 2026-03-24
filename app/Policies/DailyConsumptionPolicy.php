<?php

namespace App\Policies;

use App\Models\DailyConsumption;
use App\Models\User;

class DailyConsumptionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function view(User $user, DailyConsumption $dailyConsumption): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function update(User $user, DailyConsumption $dailyConsumption): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function delete(User $user, DailyConsumption $dailyConsumption): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }
}

