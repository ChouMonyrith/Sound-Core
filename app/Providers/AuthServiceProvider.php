<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Sound;
use App\Policies\SoundPolicy;
use Illuminate\Support\Facades\View;

class AuthServiceProvider extends ServiceProvider
{
    
    protected $policies = [
        Sound::class => SoundPolicy::class,  
    ];

    
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-sound', function ($user, $sound) {
            return $user->id === $sound->user_id || $user->role === 'admin';
        });

        Gate::define('create-sound', function ($user) {
            return in_array($user->role, ['admin', 'creator']);
        });

        Gate::define('approve-sound', function ($user) {
            return $user->role === 'admin';
        });

        View::composer('*', function ($view) {
            $countPending = Sound::where('status', 'pending')->count();
            $view->with('countPending', $countPending);
        });
    }
}
