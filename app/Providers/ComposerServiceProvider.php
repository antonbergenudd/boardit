<?php

namespace boardit\Providers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            /** @var \Illuminate\Contracts\View\View $view */
            $view->with('cart_qty', count(Cart::content()));
        });
    }
}
