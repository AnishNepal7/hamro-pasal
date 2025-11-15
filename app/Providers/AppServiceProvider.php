<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        $this->app->singleton('shared.notifications', function ($app) {
            if (Auth::check()) {
                
                return Auth::user()->unreadNotifications()->limit(5)->get();
            }
            return collect();
        });

        View::composer('*', function ($view) {
            $view->with('notifications', resolve('shared.notifications'));
        });
    }
}