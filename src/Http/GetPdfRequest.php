<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 12.5.2017 г.
 * Time: 18:03 ч.
 */
namespace Omniship\Fancourier\Http;

use Infifni\FanCourierApiClient\Client;
use Infifni\FanCourierApiClient\Request\GetAwb;
use Omniship\Fancourier\FanClient;

class GetPdfRequest extends AbstractRequest
{
    /**
     * @return integer
     */
    public function getData() {
        return [
            'bol_id' => $this->getBolId(),
            'type' => $this->getOtherParameters('printer_type')
        ];
    }

    /**
     * @param mixed $data
     * @return GetPdfResponse
     */
    public function sendData($data) {
        if($this->getLanguageCode() != 'ro'){
            $this->setLanguageCode('en');
        }
        $GetPDF = (new FanClient($this->getClientId(), $this->getUsername(), $this->getPassword()))->getPdfAwb([
            'nr' => $data['bol_id'],
            'page' => $this->getPdfSize(),
            'ln' => $this->getLanguageCode()
        ]);
        return $this->createResponse($GetPDF);
    }

    /**
     * @param $data
     * @return GetPdfResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new GetPdfResponse($this, $data);
    }

    /**
     * @return string
     */
    protected function getPdfSize()
    {
        if(in_array($type = strtoupper($this->getOtherParameters('printer_type')), [GetAwb::PAGE_A4_ALLOWED_VALUE, GetAwb::PAGE_A5_ALLOWED_VALUE, GetAwb::PAGE_A6_ALLOWED_VALUE])) {
            return $type;
        }

        return GetAwb::PAGE_A4_ALLOWED_VALUE;
    }
}
