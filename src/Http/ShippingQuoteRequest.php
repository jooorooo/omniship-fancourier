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
            $package = $this->getNumberOfPieces();
        } else {
            $envelope = $this->getNumberOfPieces();
            $package = 0;
        }
        switch ($this->getPayer()){
            case 'SENDER': $payer = 'expeditor';break;
            case 'RECEIVER': $payer = 'destinatar'; break;
            default: $payer = $this->getPayer();
        }
        $options = [];
        $check_at_delivery = $this->getOtherParameters('check_at_delivery') ? array_push($options, 'A') : $options;
        $epod = $this->getOtherParameters('epod') ?   array_push($options, 'X') : $options;
        $to_office = $this->getOtherParameters('to_office') ?  array_push($options, 'D') : $options;
        $saturday_delivery = $this->getOtherParameters('saturday_delivery') ?  array_push($options, 'S') : $options;
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
            'val_decl' =>  $this->getOtherParameters('declarate_value') ? $this->getDeclaredAmount() : '',
            'plata_ramburs' => $payer,
            'optiuni' => implode(',', $options)
        ];
    }

    public function sendData($data)
    {
      //  dump($data);
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
      //  dd($calculate);
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
