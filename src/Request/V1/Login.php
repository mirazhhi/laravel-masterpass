<?php

namespace Mirazhhi\Masterpass\Request\V1;

use GuzzleHttp\Client;
use Mirazhhi\Masterpass\Request\WalletRequest;
use Illuminate\Support\Facades\Validator;
use Mirazhhi\Masterpass\Request\V2\GetRequestToken;

class Login extends WalletRequest
{
    protected $url = 'https://testwallet.masterpass.ru/masterpassapi/Login';

    protected $requestToken;

    public function __construct(GetRequestToken $getRequestToken)
    {

    }

    public function validate()
    {
        return $this;
    }

    public function prepareData(array $data)
    {
        $requestToken = $this->getRequestToken($data)->RequestToken;

        $this->payload = [
            'Fingerprint' => 'T1M9QW5kcm9pZDtEZXZpY2VJZD0xZTZlODllYy01NjU5LTQxMzMtYmZkNy03NzFkNDM5NzJiYWU7UGhvbmVJZD02NmRjZTY3ODhmZTcxZGI2O01vZGVsPVNNLUc3NzBGO09TVmVyc2lvbj0zMDtPdGhlcj1Jc0RldmljZVJvb3RlZDpmYWxzZTtWZXJzaW9uUmVsZWFzZT0xMTtUaW1lWm9uZT1Bc2lhL0FsbWF0eTtXaWR0aD0wO0hlaWdodD0w',
            'RequestToken' => $requestToken,
            'Channel' => 1,
//            'PhoneCheckDate' => true,
//            'MasterpassOTP' => true,
        ];
        return $this;
    }
}
