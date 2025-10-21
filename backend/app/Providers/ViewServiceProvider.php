<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SidebarItem;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.sidebar', function ($view) {
            $user = auth()->user();
            $role = $user->role ?? 'admin';

            $sidebarItems = SidebarItem::whereNull('parent_id')
                ->forRole($role)
                ->orderBy('order')
                ->get()
                ->map(function ($item) use ($role) {
                    $item->children = $item->visibleChildren($role);
                    return $item;
                });

            $view->with([
                'user' => $user,
                'userInfo' => $user->info ?? null,
                'sidebarItems' => $sidebarItems,
            ]);
        });
    }
}
