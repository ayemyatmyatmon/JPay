<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        View::composer('*', function ($view) {
            $unread_noti_count=0;
            if(auth()->guard('web')->check()){
                $user=auth()->guard('web')->user();
                $unread_noti_count=$user->unreadNotifications()->count();
                
            }
            $view->with('unread_noti_count', $unread_noti_count);

        });
    }
}
