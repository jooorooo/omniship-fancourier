<?php

namespace Omniship\Fancourier\Http;
use Infifni\FanCourierApiClient\Client;

class ShippingQuoteRequest extends AbstractRequest
{

    public function getData()
    {

        if($this->getPackageType() == 'package'){
            $envelope = 0;
            $package = $this->getNumberOfPieces();
        } else {
            $envelope = $this->getNumberOfPieces();
            $package = 0;
        }
        return [
            'serviciu' => $this->getServiceId(),
            'localitate_dest' => $this->getReceiverAddress()->getCity()->name,
            'judet_dest' => $this->getReceiverAddress()->getLocal()['name'],
            'plicuri' => $envelope,
            'colete' => $package,
            'greutate' => $this->getWeight(), // total weight of the shipment
            'lungime' => $this->getPieces()[0]->getWidth(),
            'latime' => $this->getPieces()[0]->getDepth(),
            'inaltime' =>  $this->getPieces()[0]->getHeight(),
            'val_decl' => $this->getDeclaredAmount(),
            'plata_ramburs' => $this->getPayer()
        ];
    }

    public function sendData($data)
    {
        $calculate = (new Client($this->getClientId(), $this->getUsername(), $this->getPassword()))->price($data);
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
