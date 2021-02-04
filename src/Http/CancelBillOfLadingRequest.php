<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 16:55 ч.
 */

namespace Omniship\Fancourier\Http;

use Infifni\FanCourierApiClient\Client;

class CancelBillOfLadingRequest extends AbstractRequest
{

    /**
     * @return array
     */
    public function getData() {

        return [
            'bol_id' => $this->getBolId(),
        ];
    }

    /**
     * @param mixed $data
     * @return CancelBillOfLadingResponse
     */
    public function sendData($data) {

        $CreateBill = (new Client($this->getClientId(), $this->getUsername(), $this->getPassword()))->deleteAwb(['AWB' => $data['bol_id']]);
        return $this->createResponse($CreateBill);
    }

    /**
     * @param $data
     * @return CancelBillOfLadingResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new CancelBillOfLadingResponse($this, $data);
    }

}
