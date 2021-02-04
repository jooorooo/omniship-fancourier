<?php

namespace Omniship\Fancourier\Http;
use Omniship\Consts;

class ShippingQuoteResponse extends AbstractResponse
{
    public function getData()
    {
        $result = [];
        if(!empty($this->data)) {
            $result = [
                    'id' => $this->request->getServiceId(),
                    'name' => null,
                    'description' => null,
                    'price' => $this->data,
                    'pickup_date' => null,
                    'pickup_time' => null,
                    'delivery_date' =>  null,
                    'delivery_time' =>  null,
                    'currency' => $this->getRequest()->getCurrency(),
                    'tax' =>null,
                    'insurance' => 0,
                    'exchange_rate' =>  null,
                    'payer' => $this->getRequest()->getPayer()
                ];
        }
        return $result;
    }
}
