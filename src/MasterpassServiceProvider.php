<?php


namespace Masterpass;

use Illuminate\Support\ServiceProvider;

class MasterpassServiceProvider extends ServiceProvider
{
    public function boot()
    {
        dd('Do some thung');
    }

    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub
    }
}
