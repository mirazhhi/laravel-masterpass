<?php

namespace Mirazhhi\Masterpass\Request\V2;

use Mirazhhi\Masterpass\Request\WalletRequest;

class Postback extends WalletRequest
{
//    protected $contentType = 'application/json';
    protected $body = 'json';


    protected $url = 'https://testwallet.masterpass.ru/mpapiv2/Postback';

    public function validate() : Postback
    {
        return $this;
    }

    public function prepareData(array $data = [])
    {
        $this->payload['Amount']          = $data['amount'];
        $this->payload['CurrencyCode']    = $data['currency_code'];
        $this->payload['CVC2']            = $data['cvc2'];
//        $this->payload['Channel']         = $data['channel'];
        $this->payload['DealDate']        = $data['deal_date'];
//        $this->payload['ErrCode']         = $data['err_code'];
//        $this->payload['MerchantOrderId'] = $data['merchant_order_id'];
        $this->payload['MerchantName']    = $data['merchant_name'];
        $this->payload['OriginalOrderId'] = $data['original_order_id'];
        $this->payload['Session']         = $data['session'];
        $this->payload['Success']         = $data['success'];
//        $this->payload['SubMerchantName'] = $data['submerchant_name'];
        $this->payload['ThreeDS']         = $data['3ds'];
        $this->payload['Token']           = $data['token'];
        $this->payload['TransactionType'] = $data['transaction_type'];
//        $this->payload['Description']     = $data['description'];
//        $this->payload['ETID']            = $data['etid'];
//        $this->payload['MITA']            = $data['mita'];
//        $this->payload['RRN']             = $data['rrn'];


        $this->payload = [
            'DATA' => json_encode($this->payload)
        ];
//        dd($this->payload);
        return $this;
    }
}



