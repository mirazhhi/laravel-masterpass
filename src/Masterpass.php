<?php

namespace Mirazhhi\Masterpass;

use GuzzleHttp\Client;
use Mirazhhi\Masterpass\Oauth;
use Illuminate\Support\Facades\Cache;
use Mirazhhi\Masterpass\Request\V1\Login;
use Mirazhhi\Masterpass\Request\V2\GetRequestToken;
use Illuminate\Foundation\Application;

class Masterpass extends Application
{
    protected $app;

    /**
     * Masterpass constructor.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getRequestToken(array $data)
    {
        return $this->app->make(GetRequestToken::class, [
            'data' => $data
        ])->execute();
    }

    /**
     * Login
     */
    public function login(array $data)
    {
        dd($this->getRequestToken());

        dd($this->app->make(Login::class));
    }

    public function getCards()
    {
        $this->payload = [
            'Session' => Cache::get('session_merchant')
        ];
        $this->url = 'https://testwallet.masterpass.ru/masterpassapi/GetCards';
        return $this->requestWallet();
    }
}
