<?php

namespace App\Policies;

use App\Models\Sound;
use App\Models\User;

class SoundPolicy
{
    /**
     * Determine if the user can create a sound.
     */
    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'creator']);
    }

    /**
     * Determine if the user can update a sound.
     */
    public function update(User $user, Sound $sound)
    {
        return $user->id === $sound->user_id || $user->role === 'admin';
    }

    /**
     * Determine if the user can delete a sound.
     */
    public function delete(User $user, Sound $sound)
    {
        return $user->id === $sound->user_id || $user->role === 'admin';
    }

    /**
     * Determine if the user can approve a sound.
     */
    public function approve(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can view a sound.
     */
    public function view(User $user, Sound $sound)
    {
        return $sound->status === 'approved' || $user->id === $sound->user_id || $user->role === 'admin';
    }

    public function viewAny(User $user) 
    {
        return $user->role === 'admin';
    }
    
}
