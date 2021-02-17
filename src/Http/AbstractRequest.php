<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 16:55 ч.
 */

namespace Omniship\Fancourier\Http;

use Omniship\Interfaces\RequestInterface;
use Omniship\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest implements RequestInterface
{

    protected function validateLanguage(){
        $language = $this->getLanguageCode();
        if(strtolower($language) != 'ro'){
            return 'en';
        }
        return 'ro';
    }

    public function getClientId(){

        return $this->getParameter('client_id');
    }

    public function SetClientId($value){
        return $this->setParameter('client_id', $value);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    abstract protected function createResponse($data);

}
