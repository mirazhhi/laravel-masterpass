<?php


namespace Mirazhhi\Masterpass;

use Illuminate\Support\ServiceProvider;

class MasterpassServiceProvider extends ServiceProvider
{
    const V1 = 'v1';
    const V2 = 'v2';

    protected $masterpass;

    protected $walletEndpoints;

    public function register()
    {
        $this->walletEndpoints = config('masterpass.walletEndpoints');
//        $this->masterpass = $this->app->make(Masterpass::class);
    }

    public function boot()
    {

    }
}
