<?php

namespace App\Policies;

use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StockTransactionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StockTransaction $stockTransaction): bool
    {
        return $user->role == 'admin' || $user->role == 'staff';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 'admin' || $user->role == 'staff';
    }
}
