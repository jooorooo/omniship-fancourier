<?php

namespace Omniship\Fancourier\Http;
use Omniship\Common\ShippingQuoteBag;
use Omniship\Consts;

class ShippingQuoteResponse extends AbstractResponse
{
    public function getData()
    {
        $result = new ShippingQuoteBag();
        foreach ($this->data as $data){
            if(!empty($this->data)) {
                if (is_numeric($data['price'])) {
                    $result->push([
                        'id' => $data['name'],
                        'name' => $data['name'],
                        'description' => null,
                        'price' => $data['price'],
                        'pickup_date' => null,
                        'pickup_time' => null,
                        'delivery_date' => null,
                        'delivery_time' => null,
                        'currency' => $this->getRequest()->getCurrency(),
                        'tax' => null,
                        'insurance' => 0,
                        'exchange_rate' => null,
                        'payer' => $this->getRequest()->getPayer()
                    ]);
                }
            }
        }
        return $result;
    }
}
