<?php

namespace Omniship\Fancourier\Http;
use Doctrine\Common\Collections\ArrayCollection;
use Infifni\FanCourierApiClient\Client;

class ShippingQuoteRequest extends AbstractRequest
{

    public function getData()
    {

        if($this->getPackageType() == 'package'){
            $envelope = 0;
            $package = count($this->getItems());
        } else {
            $envelope = count($this->getItems());
            $package = 0;
        }
        return [
            'serviciu' =>  $this->getServiceId(),
            'localitate_dest' => $this->getReceiverAddress()->getCity()->getName(),
            'judet_dest' => $this->getReceiverAddress()->getState()->getName(),
            'plicuri' => $envelope,
            'colete' => $package,
            'greutate' => $this->getWeight(), // total weight of the shipment
            'lungime' => $this->getItems()->first()->getWidth(),
            'latime' => $this->getItems()->first()->getDepth(),
            'inaltime' => $this->getItems()->first()->getHeight(),
            'val_decl' => $this->getDeclaredAmount(),
            'plata_ramburs' => $this->getPayer()
        ];
    }

    public function sendData($data)
    {
        $calculate = [];
        foreach ($data['serviciu'] as $s) {
            try {

                $data['serviciu'] = $s;
                $calculate[] = [
                    'name' => $s,
                    'price' => (new Client($this->getClientId(), $this->getUsername(), $this->getPassword()))->price($data)
                ];
            } catch (\Exception $e){
                continue;
            }
        }
        return $this->createResponse($calculate);
    }

    /**
     * @param $data
     * @return ShippingQuoteResponse
     */
    protected function createResponse($data)
    {
        $response = new ShippingQuoteResponse($this, $data);
        return $this->response = new ShippingQuoteResponse($this, $data);
    }

}
