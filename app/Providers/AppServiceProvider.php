<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
{
    View::composer('*', function ($view) {
        if (Auth::check()) { // Ensure the user is authenticated
            $notifications = DB::table('notifications')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            $unreadNotificationsCount = DB::table('notifications')
                ->where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();

            $view->with(compact('notifications', 'unreadNotificationsCount'));
        } else {
            $view->with(['notifications' => [], 'unreadNotificationsCount' => 0]);
        }
    });
    }
}

