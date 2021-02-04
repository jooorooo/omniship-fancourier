<?php

namespace Omniship\Fancourier\Http;
use Omniship\Common\ServiceBag;

class TrackingParcelResponse extends AbstractResponse
{
    public function getData()
    {
        dd($this);
        $result = new ServiceBag();
        if(!is_null($this->getCode())) {
            return $result;
        }

        if(!empty($this->data)) {
            foreach($this->data AS $services) {
                foreach($services as $service) {
                    $result->push([
                        'id' => $service,
                        'name' => $service,
                    ]);
                }
            }
        }
        return $result;
    }
}
