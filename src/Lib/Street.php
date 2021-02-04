<?php

namespace Omniship\Fancourier\Lib;

use Omniship\Address\Street as BaseStreet;

class Street extends BaseStreet
{

    /**
     * Get zip code
     */
    public function getZipcode()
    {
        return $this->getParameter('zipcode');
    }

    /**
     * Set zip code
     * @param $value
     * @return $this
     */
    public function setZipcode($value)
    {
        return $this->setParameter('zipcode', $value);
    }

    /**
     * Get county name
     */
    public function getCounty()
    {
        return $this->getParameter('county');
    }

    /**
     * Set county name
     * @param $value
     * @return $this
     */
    public function setCounty($value)
    {
        return $this->setParameter('county', $value);
    }


    /**
     * Set city name
     */
    public function getCity(){
        return $this->getParameter('city');
    }

    /**
     * Set city name
     * @param $value
     * @return $this
     */
    public function setCity($value){
        return $this->setParameter('city', $value);
    }

}
