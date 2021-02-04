<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 16:55 ч.
 */

namespace Omniship\Fancourier\Http;

use Infifni\FanCourierApiClient\Client;

class ValidateCredentialsRequest extends AbstractRequest
{


    public function getData()
    {

    }

    public function sendData($data)
    {
        $services = (new Client($this->getClientId(),$this->getUsername(),$this->getPassword()))->exportServices();
        return $this->createResponse($services);
    }

    protected function createResponse($data)
    {
        return $this->response = new ValidateCredentialsResponse($this, $data);
    }

}
