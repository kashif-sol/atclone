<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AppUninstalledJob  implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    protected $shop;

    // protected $_addButtonCartService;

    /**
     * Create a new job instance.
     *
     * @param string $shopDomain The shop's myshopify domain
     * @param object $webhook The webhook data (JSON decoded)
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    	Log::info('delete web hook');
        Log::info('shopDomain: '.$this->shopDomain);
        $merchat = DB::table('users')->where('name', '=',  $this->shopDomain)->delete();
        Log::info('deleted merchant data: :  . ' .  $merchat);
        return true;

    }

    /**
     * Finds the shop based on domain from the webhook.
     *
     * @return Shop|null
     */
    protected function findShop()
    {
        return User::where(['shopify_domain' => $this->shopDomain])->first();
    }
}
