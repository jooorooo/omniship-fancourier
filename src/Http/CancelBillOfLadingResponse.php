<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 17:22 ч.
 */

namespace Omniship\Fancourier\Http;

use Infifni\FanCourierApiClient\Exception\FanCourierInstanceException;

class CancelBillOfLadingResponse extends AbstractResponse
{

    /**
     * @return bool
     */
    public function getData()
    {
        if((int)$this->data == 0) {
            return false;
        }
        return $this->data;
    }

}
