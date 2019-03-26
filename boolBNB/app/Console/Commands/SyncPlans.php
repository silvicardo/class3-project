<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Braintree_Plan;
use App\Plan;

class SyncPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'braintree:sync-plans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync with online plans on Braintree';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
          // Svuota la table
          Plan::truncate();

          // Recupera i plans da BrainTree
          $braintreePlans = Braintree_Plan::all();

          // Popola la table plans con le istanze ricevute
          foreach ($braintreePlans as $braintreePlan) {
              Plan::create([
                  'name' => $braintreePlan->name,
                  'slug' => str_slug($braintreePlan->name),
                  'braintree_plan' => $braintreePlan->id,
                  'cost' => $braintreePlan->price,
                  'description' => $braintreePlan->description,
              ]);
          }
      }

}
