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

        $sender_address = $this->getSenderAddress();
        $receiver_adress = $this->getReceiverAddress();
        return [
            'tip_serviciu' =>$this->getServiceId(),
            'banca' => '',
            'iban' =>  '',
            'nr_plicuri' =>  $envelope,
            'nr_colete' => $package,
            'greutate' => $this->getWeight(),
            'plata_expeditie' => 'ramburs',
            'ramburs_bani' => 100,
            'plata_ramburs_la' => GenerateAwb::RECIPIENT_ALLOWED_VALUE,
            'valoare_declarata' => $this->getDeclaredAmount(),
            'persoana_contact_expeditor' => $sender_address->getFullName(),
            'observatii' => $this->getClientNote(),
            'continut' => '',
            'nume_destinatar' => 'TEsdas',
            'persoana_contact' => $receiver_adress->getFullName(),
            'telefon' => $receiver_adress->getPhone(),
            'fax' => '31231232',
            'email' => 'dasdsa@abv.bg',
            'judet' => $receiver_adress->getLocal()['name'],
            'localitate' => $receiver_adress->getCity()->getName(),
            'strada' => $receiver_adress->getStreet()->getName(),
            'nr' => $receiver_adress->getStreetNumber(),
            'cod_postal' => $receiver_adress->getPostCode(),
            'bl' => $receiver_adress->getBuilding() ?? '',
            'scara' => $receiver_adress->getEntrance() ?? '',
            'etaj'  => $receiver_adress->getFloor() ?? '',
            'apartament' => $receiver_adress->getApartment() ?? '',
            'inaltime_pachet' => '',
            'lungime_pachet' => '',
            'restituire' => '',
            'centru_cost' => '',
            'optiuni' => '',
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
