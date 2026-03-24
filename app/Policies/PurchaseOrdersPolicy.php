<?php

namespace App\Policies;

use App\Models\PurchaseOrders;
use App\Models\User;

class PurchaseOrdersPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function view(User $user, PurchaseOrders $purchaseOrder): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function update(User $user, PurchaseOrders $purchaseOrder): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }

    public function delete(User $user, PurchaseOrders $purchaseOrder): bool
    {
        return $user->hasAnyRoles(['admin', 'stockeeper']);
    }
}

