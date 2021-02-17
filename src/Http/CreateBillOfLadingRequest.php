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
        $this->getNumberOfPieces();
        $sender_address = $this->getSenderAddress();
        $receiver_adress = $this->getReceiverAddress();
        $declared_amount = '';
        $declared_side = '';
        $check_at_delivery = $this->getParameter('check_at_delivery') ? 'A' : '';
        $saturday_delivery = $this->getOtherParameters('saturday_delivery') ? 'S' : '';
        $epod = $this->getOtherParameters('epod') ? 'X' : '';
        $tooffice = $receiver_adress->getOffice() ? 'D' : '';
        return [
            'tip_serviciu' => $this->getServiceId(), // required
            'banca' => '',
            'iban' =>  '',
            'nr_plicuri' =>  $envelope, // required
            'nr_colete' => $package, // required
            'greutate' => $this->getWeight(), // required
            'plata_expeditie' => $this->getPayer(), // required
            'ramburs_bani' => $this->getDeclaredAmount(), // required
            'plata_ramburs_la' => $this->getPayer(), // required
            'valoare_declarata' => $this->getCashOnDeliveryAmount(),
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
            'optiuni' => $check_at_delivery.$saturday_delivery.$epod.$tooffice,
            'packing' => '',
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
