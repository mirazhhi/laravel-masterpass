<?php

namespace Mirazhhi\Masterpass\Request\V1;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Mirazhhi\Masterpass\Request\WalletRequest;

class GetCards extends  WalletRequest
{
    protected $url = 'https://testwallet.masterpass.ru/masterpassapi/GetCards';

    public function validate() : GetCards
    {
        return $this;
    }

    public function prepareData(array $data = [])
    {
        $this->payload['Session'] = json_decode(Cache::get('merchant'))->Session;

        return $this;
    }
}
