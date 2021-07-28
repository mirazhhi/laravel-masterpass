<?php

namespace Masterpass\Request;

use GuzzleHttp\Client;
use Masterpss\Exceptions\MasterpassExceptions;

abstract class WalletRequest
{
    /**
     * @var $client Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __constructor(Client $client)
    {
        $this->client = $client;
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

    abstract public function validate();

    abstract public function prepareData();
}
