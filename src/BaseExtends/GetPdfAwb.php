<?php

namespace Omniship\Fancourier\BaseExtends;

use Infifni\FanCourierApiClient\Request\GetAwb;

class GetPdfAwb extends GetAwb
{
    /**
     * @return string
     */
    protected function getApiPath(): string
    {
        return 'view_awb_integrat_pdf.php';
    }
}