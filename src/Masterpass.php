<?php

namespace Mirazhhi\Masterpass;

use GuzzleHttp\Client;
use Mirazhhi\Masterpass\Oauth;
use Illuminate\Support\Facades\Cache;
use Mirazhhi\Masterpass\Request\V1\GetCards;
use Mirazhhi\Masterpass\Request\V1\Login;
use Mirazhhi\Masterpass\Request\V1\SaveCard;
use Mirazhhi\Masterpass\Request\V2\GetRequestToken;
use Illuminate\Foundation\Application;
use Mirazhhi\Masterpass\Request\V2\Postback;

class Masterpass extends Application
{
    protected $app;

    protected $merchant;

    protected $phone;

    /**
     * Masterpass constructor.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getRequestToken(array $data)
    {
        return $this->app->make(GetRequestToken::class)->prepareData($data)->execute();
    }

    /**
     * Login
     */
    public function login(array $data)
    {
        return $this->app->make(Login::class)->prepareData($data)->execute();
    }

    public function getCards()
    {
        return $this->app->make(GetCards::class)->prepareData()->execute();
    }


    public function saveCard(array $data)
    {
        return $this->app->make(SaveCard::class)->prepareData($data)->execute();
    }

    public function postback(array $data)
    {
        return $this->app->make(Postback::class)->prepareData($data)->execute();
    }
}
