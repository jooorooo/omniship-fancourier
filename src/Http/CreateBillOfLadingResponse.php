<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 17:22 ч.
 */

namespace Omniship\Fancourier\Http;


use Infifni\FanCourierApiClient\Request\GetAwb;
use Omniship\Common\Bill\Create;
use Infifni\FanCourierApiClient\Client;

class CreateBillOfLadingResponse extends AbstractResponse
{
    /**
     * @var Parcel
     */
    protected $data;
    /**
     * @return Create
     */
    public function getData()
    {

        $result = new Create();
        $data = $this->data[0] ?? null;
        $client = (new Client($this->getRequest()->getClientId(),$this->getRequest()->getUsername(), $this->getRequest()->getPassword()));
        $GetPDF = $client->getAwb([
            'nr' => $data['awb'],
            'page' => GetAwb::PAGE_A4_ALLOWED_VALUE,
            'ln' => GetAwb::LANGUAGE_RO_ALLOWED_VALUE
        ]);
        $result->setServiceId($data['sent_params']['tip_serviciu']);
        $result->setBolId($data['awb']);
        $result->setBillOfLadingSource(base64_encode($GetPDF));
        $result->setBillOfLadingType($result::PDF);
        $result->setEstimatedDeliveryDate(null);
        $result->setInsurance(0.0);
        $result->setCashOnDelivery(0.0);
        $result->setTotal(!empty($data['cost']) ? $data['cost'] : 0.0);
        $result->setCurrency('RON');

        return $result;
    }

}
