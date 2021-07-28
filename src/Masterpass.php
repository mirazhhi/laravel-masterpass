<?php

namespace Mirazhhi\Masterpass;

use GuzzleHttp\Client;
use Mirazhhi\Masterpass\Oauth;
use Illuminate\Support\Facades\Cache;

class Masterpass
{
    /**
     * @var $exportPassword
     */
    protected $exportPassword;

    /**
     * @var $consumerKey
     */
    protected $consumerKey = '927d9436c4e34ae8876a34b7142cc244';

    /**
     * @var $certPassword
     */
    protected $certPassword = '5a622bb59c';

    /**
     * @var string
     */
    protected $httpMethod = 'POST';

    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $client;

    protected $privateKey;

    protected $payload;
    private $requestToken;

    /**
     * Masterpass constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->loadPrivateKey();
    }

    /**
     * @return string
     */
    private function certPath()
    {
        return public_path() . '/certificate.pfx';
    }

    /**
     *
     */
    protected function loadPrivateKey()
    {
        $this->privateKey = Oauth::loadSigningKey(
          $this->certPath(),
          $this->certPassword
        );
    }

    protected function getRequestMethod()
    {
        return $this->httpMethod;
    }

    protected function getRequestURL()
    {
        return $this->url;
    }

    protected function payload()
    {
        return $this->payload;
    }

    /**
     * Error
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestWallet()
    {
        $res = $this->client->request(
            $this->getRequestMethod(),
            $this->getRequestURL(),
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    OAuth::AUTHORIZATION_HEADER_NAME => $this->makeSignature()
                ],
                'form_params' => $this->payload()
            ]
        );


        return json_decode($res->getBody()->getContents());
    }


    protected function makeSignature()
    {
        return Oauth::getAuthorizationHeader(
            $this->getRequestURL(),
            $this->getRequestMethod(),
            $this->payload(), // 'MerchantName=Esentai&Phone=77079497483'
            $this->consumerKey,
            $this->privateKey
        );
    }


    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRequestToken($data)
    {
        $this->payload = $data;
        $this->url = 'https://testwallet.masterpass.ru/mpapiv2/GetRequestToken';
        return $this->requestWallet();
    }

    public function login($data, $payload) {
        if (Cache::get('session_merchant')) {
            return false;
        }
        $requestToken = $this->getRequestToken($data)->RequestToken;
//        dd($requestToken);
        $this->payload = [
            'Fingerprint' => 'T1M9QW5kcm9pZDtEZXZpY2VJZD0xZTZlODllYy01NjU5LTQxMzMtYmZkNy03NzFkNDM5NzJiYWU7UGhvbmVJZD02NmRjZTY3ODhmZTcxZGI2O01vZGVsPVNNLUc3NzBGO09TVmVyc2lvbj0zMDtPdGhlcj1Jc0RldmljZVJvb3RlZDpmYWxzZTtWZXJzaW9uUmVsZWFzZT0xMTtUaW1lWm9uZT1Bc2lhL0FsbWF0eTtXaWR0aD0wO0hlaWdodD0w',
            'RequestToken' => $requestToken,
            'Channel' => 1,
//            'PhoneCheckDate' => 'sef',
//            'MasterpassOTP' => true,
        ];
        $this->url = 'https://testwallet.masterpass.ru/masterpassapi/Login';

        Cache::put('session_merchant', $this->requestWallet()->Session);
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
