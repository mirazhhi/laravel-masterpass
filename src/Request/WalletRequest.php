<?php

namespace Mirazhhi\Masterpass\Request;

use GuzzleHttp\Client;
use Masterpss\Exceptions\MasterpassExceptions;
use Mirazhhi\Masterpass\Oauth;

abstract class WalletRequest
{
    /**
     * Request method
     *
     * @var $httpMethod string
     */
    protected $httpMethod = 'POST';

    /**
     * Masterpass wallet endpoint URLs
     *
     * @var $url string
     */
    protected $url;

    /**
     * Guzzle Http Client
     *
     * @var $client Client
     */
    protected $client;

    /**
     *
     * @var array $payload
     */
    protected $payload;

    /**
     * @var $exportPassword
     */
    protected $exportPassword;

    /**
     * @var $consumerKey
     */
    protected $consumerKey;

    /**
     * @var $certPassword
     */
    protected $certPassword;

    /**
     * @var $privateKey
     */
    protected $privateKey;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param Client $client
     */
    public function __construct(Client $client, array $data = []) {
        $this->client       = $client;
        $this->certPassword = config('masterpass.certPassword');
        $this->consumerKey  = config('masterpass.consumerKey');
        $this->data         = $data;
        $this->loadPrivateKey();
    }

    /**
     * @param string $name
     * @param $value
     * @return mixed
     * @throws MasterpassException
     * getter и setter для свойств
     *
     */
    public function __call(string $name, $value = null)
    {
        if (is_null($value) || empty($value)) { // Оставим по умолчанию
            return false;
        }

        if(Str::startsWith($name, 'set') && $property = Str::camel(Str::substr($name, 3)))
        {
            if (property_exists($this, $property)) {
                return $this->{$property} = Arr::first($value);
            }
        }

        throw new MasterpassException('NotFoundMethodName');
    }

    abstract public function validate() : WalletRequest;

    abstract public function prepareData(array $data = []);

    public function execute()
    {
        return $this->validate()->request();
    }

    protected function loadPrivateKey()
    {
        $this->privateKey = Oauth::loadSigningKey(
            $this->certPath(),
            $this->certPassword
        );
    }

    /**
     * @return string
     */
    private function certPath()
    {
        return public_path() . '/certificate.pfx';
    }

    /**
     * @return string Authorization Header OAUTH 1.0
     */
    protected function makeSignature()
    {
        return Oauth::getAuthorizationHeader(
            $this->getRequestURL(),
            $this->getRequestMethod(),
            $this->payload(),
            $this->consumerKey,
            $this->privateKey
        );
    }

    /**
     * Error
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request()
    {
//        if ($this->body === 'json') {
//            dd($this->getRequestURL(), $this->body, $this->contentType);
//        }

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

    protected function payload()
    {
        return $this->payload;
    }

    protected function getRequestMethod()
    {
        return $this->httpMethod;
    }

    protected function getRequestURL()
    {
        return $this->url;
    }
}
