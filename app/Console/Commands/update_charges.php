<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Osiset\ShopifyApp\Storage\Models\Charge as ChargeModel;
use Osiset\ShopifyApp\Services\ChargeHelper;
use App\User;

class update_charges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:charges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $chs = resolve(ChargeHelper::class);
        $shops = User::all();

        // Loop all shops
        foreach ($shops as $shop) {
            $charge = new ChargeModel();
            $charge->user_id = $shop->id;
            $charge->charge_id = $shop->charge_id;
            $charge->type = 'RECURRING';
            if ($shop->charge_id) {
                $charge->status = 'ACTIVE';
            }
            $charge->billing_on = $shop->created_at;
            $charge->created_at = $shop->created_at;
            $charge->updated_at = $shop->created_at;
            $charge->activated_on = $shop->created_at;
            $charge->trial_ends_on = $shop->created_at;
            $charge->trial_days = '0';
            $charge->plan_id = '1';
            $charge->price = '4.99';
            $charge->capped_amount = '999';
            $charge->description = null;
            $charge->reference_charge = null;

            // Save the charge
            $charge->save();
        }
        return 0;
    }
}
