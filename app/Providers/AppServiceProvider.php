<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * Currently FreeForex is not active, to change the feed, simply
     * remove the FloatRates binding and enable th FreeForex
     * binding.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Convert with Floatrates
         *
         * */
        $this->app->bind(
            'App\CurrencyConverterInterface',
            'App\ConvertWithFloatRates');

        /*
         * Convert with FreeForex.
         *
         * */
//        $this->app->bind(
//            'App\CurrencyConverterInterface',
//            'App\ConvertWithFreeForEx');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
