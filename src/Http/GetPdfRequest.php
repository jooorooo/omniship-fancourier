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
        $GetPDF = (new Client($this->getClientId(), $this->getUsername(), $this->getPassword()))->getAwb([
            'nr' => $data['bol_id'],
            'page' => GetAwb::PAGE_A4_ALLOWED_VALUE,
            'ln' => $this->getLanguageCode()
        ]);
        return $this->createResponse($GetPDF);
    }

    /**
     * @param $data
     * @return GetPdfResponse
     */
    protected function createResponse($data){
        return $this->response = new GetPdfResponse($this, $data);
    }
}
