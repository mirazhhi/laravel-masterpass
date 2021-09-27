<?php

namespace Mirazhhi\Masterpass\Request\V1;

use Illuminate\Support\Facades\Cache;
use Mirazhhi\Masterpass\Request\WalletRequest;

class SaveCard extends WalletRequest
{
    protected $url = 'https://testwallet.masterpass.ru/masterpassapi/SaveCard';

    public function validate() : SaveCard
    {
        return $this;
    }

    public function prepareData(array $data = [])
    {
        $this->payload['PAN'] = $data['pan'];
//        $this->payload['Token'] = $data['token'];
        $this->payload['CardHolder'] = $data['card_holder'];
        $this->payload['ExpMonth'] = $data['exp_month'];
        $this->payload['ExpYear'] = $data['exp_year'];
        $this->payload['Session'] = $data['session'];
        $this->payload['CardName'] = $data['card_name'];
        $this->payload['Recurring'] = $data['recurring'];
        $this->payload['Comment1'] = $data['comment1'];
        $this->payload['Comment2'] = $data['comment2'];
        $this->payload['Comment3'] = $data['comment3'];

        return $this;
    }
}
