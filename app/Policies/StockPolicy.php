<?php

namespace App\Policies;

use App\Models\Stock;
use App\Models\User;

class StockPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function view(User $user, Stock $stock): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function update(User $user, Stock $stock): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function delete(User $user, Stock $stock): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }
}

