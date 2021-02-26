<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 16:55 ч.
 */

namespace  Omniship\Fancourier\Http;

use Infifni\FanCourierApiClient\Client;
use Infifni\FanCourierApiClient\Request\GenerateAwb;

class CreateBillOfLadingRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData() {
        if($this->getPackageType() == 'package'){
            $envelope = 0;
            $package = $this->getNumberOfPieces();
        } else {
            $envelope = $this->getNumberOfPieces();
            $package = 0;
        }
        $PackageList = [];
        foreach($this->getItems() as $items){
            array_push($PackageList, $items->name.'/'.$items->name.'-'.$items->id.'/'.$items->id.'/'.$items->quantity.'/'.$items->price);
        }
        $sender_address = $this->getSenderAddress();
        $receiver_adress = $this->getReceiverAddress();
        $options = [];
        $check_at_delivery = $this->getOtherParameters('check_at_delivery') ? array_push($options, 'A') : $options;
        $packing = $this->getOtherParameters('check_at_delivery') ? $packing_list = implode('|', $PackageList) : '';
        $epod = $this->getOtherParameters('epod') ?   array_push($options, 'X') : $options;
        $to_office = $receiver_adress->getOffice()  ?  array_push($options, 'D') : $options;
        $saturday_delivery = $this->getOtherParameters('saturday_delivery') ?  array_push($options, 'S') : $options;
        return [
            'tip_serviciu' => $this->getServiceId(), // required
            'banca' => '',
            'iban' =>  '',
            'nr_plicuri' =>  $envelope, // required
            'nr_colete' => $package, // required
            'greutate' => $this->getWeight(), // required
            'plata_expeditie' => $this->getPayer(), // required
            'ramburs_bani' =>  $this->getCashOnDeliveryAmount() ?? 0, // required 1
            'plata_ramburs_la' => $this->getPayer(), // required
            'valoare_declarata' => $this->getOtherParameters('declarate_value') ? $this->getDeclaredAmount() : '',
            'persoana_contact_expeditor' => $sender_address->getFullName(),
            'observatii' => $this->getOtherParameters('instructions') ?? '',
            'continut' => $this->getClientNote() ?? '',
            'nume_destinatar' =>  $receiver_adress->getFullName(), // required
            'persoana_contact' => '',
            'telefon' => $receiver_adress->getPhone(), // required
            'fax' => '',
            'email' => '',
            'judet' => $receiver_adress->getState()->getName(), // required
            'localitate' => $receiver_adress->getCity()->getName(), // required
            'strada' => $receiver_adress->getStreet() ? $receiver_adress->getStreet()->getName() : $receiver_adress->getCity()->getName(), // required
            'nr' => $receiver_adress->getStreetNumber() ?? '', // required
            'cod_postal' => $receiver_adress->getPostCode(), // required
            'bl' => $receiver_adress->getBuilding() ?? '',
            'scara' => $receiver_adress->getEntrance() ?? '',
            'etaj'  => $receiver_adress->getFloor() ?? '',
            'apartament' => $receiver_adress->getApartment() ?? '',
            'inaltime_pachet' => '',
            'lungime_pachet' => '',
            'restituire' => '',
            'centru_cost' => '',
            'optiuni' => implode('', $options),
            'packing' => $packing,
            'date_personale' => ''
        ];
    }

    public function sendData($data) {
        $CreateBill = (new Client($this->getClientId(), $this->getUsername(), $this->getPassword()))->generateAwb(['fisier' => [$data]]);
        return $this->createResponse($CreateBill);
    }

    /**
     * @param $data
     * @return ShippingQuoteResponse
     */
    protected function createResponse($data)
    {
        $response = new CreateBillOfLadingResponse($this, $data);
        return $this->response = new CreateBillOfLadingResponse($this, $data);
    }

}
