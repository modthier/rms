<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRoles(['admin', 'user']);
    }

    public function view(User $user, Order $order): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return (int) $order->user_id === (int) $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRoles(['admin', 'user']);
    }

    public function update(User $user, Order $order): bool
    {
        return $this->view($user, $order);
    }

    public function delete(User $user, Order $order): bool
    {
        return $this->view($user, $order);
    }

    public function cancel(User $user, Order $order): bool
    {
        return $this->view($user, $order);
    }
}

