<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier; //per settare € come moneta
use Braintree_Configuration;

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
      //BrainTree
      Braintree_Configuration::environment(config('services.braintree.environment'));
      Braintree_Configuration::merchantId(config('services.braintree.merchant_id'));
      Braintree_Configuration::publicKey(config('services.braintree.public_key'));
      Braintree_Configuration::privateKey(config('services.braintree.private_key'));

      Cashier::useCurrency('eur', '€');
    }
}
