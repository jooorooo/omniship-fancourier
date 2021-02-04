<?php

namespace Omniship\Fancourier;

use Omniship\Common\AbstractGateway;
use Omniship\Fancourier\Http\CancelBillOfLadingRequest;
use Omniship\Fancourier\Http\CreateBillOfLadingRequest;
use Omniship\Fancourier\Http\GetPdfRequest;
use Omniship\Fancourier\Http\ServicesRequest;
use Omniship\Fancourier\Http\TrackingParcelRequest;
use Omniship\Fancourier\Http\ShippingQuoteRequest;
use Omniship\Fancourier\Http\ValidateCredentialsRequest;

class Gateway extends AbstractGateway
{

    private $name = 'Fancourier';

    /**
     * @return stringc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'username' => '',
            'password' => '',
            'client_id' => ''
        );
    }

    public function getClientId(){
        return $this->getParameter('client_id');
    }

    public function setClientId($value){
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

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->getParameter('endpoint');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEndpoint($value)
    {
        return $this->setParameter('endpoint', $value);
    }

    /**
     * @param array|ShippingQuoteRequest $parameters
     * @return ShippingQuoteRequest
     */
    public function getQuotes($parameters = [])
    {
        if($parameters instanceof ShippingQuoteRequest) {
            return $parameters;
        }
        if(!is_array($parameters)) {
            $parameters = [];
        }
        return $this->createRequest(ShippingQuoteRequest::class, $this->getParameters() + $parameters);
    }


    /**
     * @param string $bol_id
     * @return TrackingParcelRequest
     */
    public function trackingParcel($bol_id)
    {
        return $this->createRequest(TrackingParcelRequest::class, $this->setBolId($bol_id)->getParameters());
    }

    public function getServices($parameters = []){
        return $this->createRequest(ServicesRequest::class, $parameters);
    }

    public function getClient()
    {
        return new Client($this->getUsername(), $this->getPassword(), $this->getClientId(), $this->getLanguageCode());
    }

    /**
     * @param array|CreateBillOfLadingRequest $parameters
     * @return CreateBillOfLadingRequest
     */
    public function createBillOfLading($parameters = [])
    {
        if ($parameters instanceof CreateBillOfLadingRequest) {
            return $parameters;
        }
        if (!is_array($parameters)) {
            $parameters = [];
        }
        return $this->createRequest(CreateBillOfLadingRequest::class, $this->getParameters() + $parameters);
    }

    public function cancelBillOfLading($bol_id)
    {
        $this->setBolId($bol_id);
        return $this->createRequest(CancelBillOfLadingRequest::class, $this->getParameters());
    }

    /**
     * @param $bol_id
     * @return GetPdfRequest
     */
    public function getPdf($bol_id)
    {
        return $this->createRequest(GetPdfRequest::class, $this->setBolId($bol_id)->getParameters());
    }

    public function validateCredentials(array $parameters = [], $test_mode = null)
    {
        return $this->createRequest(ValidateCredentialsRequest::class, $parameters);
    }
}
