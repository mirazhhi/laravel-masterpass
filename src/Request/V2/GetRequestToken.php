<?php

namespace Mirazhhi\Masterpass\Request\V2;

use GuzzleHttp\Client;
use Mirazhhi\Masterpass\Request\V1\Login;
use Illuminate\Support\Facades\Validator;
use Mirazhhi\Masterpass\Request\WalletRequest;

class GetRequestToken extends WalletRequest
{
    /**
     * @var string $url
     */
    protected $url = 'https://testwallet.masterpass.ru/mpapiv2/GetRequestToken';

    /**
     * @return $this
     */
    public function validate() : GetRequestToken
    {
        Validator::make($this->payload(), [
            'MerchantName' => 'required',
            'Phone'        => 'required'
        ]);

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function prepareData(array $data = [])
    {
        $this->payload['MerchantName'] = $data['merchant_name'];
        $this->payload['Phone']        = $data['phone'];

        return $this;
    }
}
