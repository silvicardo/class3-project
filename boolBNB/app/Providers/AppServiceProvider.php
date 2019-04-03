<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Cashier; //per settare € come moneta
use Braintree_Configuration;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Schema::defaultStringLength(191);
      //Carbon

      // Carbon::serializeUsing(function ($carbon) {
      //       // return $carbon->setLocale(LC_TIME, 'Italian');
      //       return $carbon->format('F');
      //   });
      //BrainTree

      Braintree_Configuration::environment(config('services.braintree.environment'));
      Braintree_Configuration::merchantId(config('services.braintree.merchant_id'));
      Braintree_Configuration::publicKey(config('services.braintree.public_key'));
      Braintree_Configuration::privateKey(config('services.braintree.private_key'));

      Cashier::useCurrency('eur', '€');
    }
}
