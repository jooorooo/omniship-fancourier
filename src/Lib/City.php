<?php

namespace Omniship\Fancourier\Lib;

use Omniship\Address\City as BaseCity;

class City extends BaseCity
{

    /**
     * Get state name
     */
    public function getState()
    {
        return $this->getParameter('state');
    }

    /**
     * Set state name
     * @param $value
     * @return $this
     */
    public function setState($value)
    {
        return $this->setParameter('state', $value);
    }

}
