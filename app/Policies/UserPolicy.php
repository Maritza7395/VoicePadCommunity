<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
      
    }
    public function different(User $userAuth, User $user){
        return $userAuth->id !== $user->id;
    }
     public function equal(User $userAuth, User $user){
        return $userAuth->id === $user->id;
    }
}
