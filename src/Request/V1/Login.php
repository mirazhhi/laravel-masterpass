<?php

namespace Mirazhhi\Masterpass\Request\V1;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Mirazhhi\Masterpass\Request\WalletRequest;
use Illuminate\Support\Facades\Validator;
use Mirazhhi\Masterpass\Request\V2\GetRequestToken;
use Illuminate\Support\Str;

class Login extends WalletRequest
{
    protected $url = 'https://testwallet.masterpass.ru/masterpassapi/Login';

    public function validate() : Login
    {
        return $this;
    }

    public function prepareData(array $data = [])
    {
        $this->payload = [
            'Fingerprint' => $data['fingerprint'],
            'RequestToken' => $data['request_token'],
            'Channel' => $data['channel'],
            'PhoneCheckDate' => $data['phone_check_date'],
            'MasterpassOTP' => $data['masterpassOTP'],
            'BioId' => $data['bioID'],
        ];

        return $this;
    }

    public function execute()
    {
//        if (Cache::get('merchant')) {
//            return Cache::get('merchant');
//        }

        $result = $this->validate()->request();
        Cache::put('merchant', json_encode($result), now()->addMinutes(15));

        return  Cache::get('merchant');
    }
}
