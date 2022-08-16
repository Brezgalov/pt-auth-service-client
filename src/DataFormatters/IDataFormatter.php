<?php

namespace Brezgalov\AuthServiceClient\DataFormatters;

use yii\httpclient\Response;

interface IDataFormatter
{
    /**
     * @param Response $response
     * @return mixed
     */
    public static function format(Response $response);
}