<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(User $user){
        return ($user->role == 'admin');
        //return true;
    }

    public function create(User $user){
        return ($user->role == 'admin');
    }

    public function store(User $user){
        return ($user->role == 'admin');
    }

    public function update(User $user){
        return ($user->role == 'admin');
    }

    public function edit(User $user){
        return ($user->role == 'admin');
    }

    public function delete(User $user){
        return ($user->role == 'admin');
    }
}
