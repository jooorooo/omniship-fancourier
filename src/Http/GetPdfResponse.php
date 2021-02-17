<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 17:22 ч.
 */

namespace Omniship\Fancourier\Http;

class GetPdfResponse extends AbstractResponse
{

    /**
     * @return bool
     */
    public function getData(){
        if(str_starts_with($this->data, 'Error') == true) {
            return false;
        }
        return $this->data;
    }

}
