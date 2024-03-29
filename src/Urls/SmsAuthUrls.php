<?php

namespace Brezgalov\AuthServiceClient\Urls;

use yii\base\Component;

/**
 * Class AuthUrls
 * @package Brezgalov\AuthServiceClient\Urls
 *
 * @property string $sendCode
 * @property string $getToken
 */
class SmsAuthUrls extends Component
{
    /**
     * @return string
     */
    public function getSendCode()
    {
        return 'sms-auth/send-code';
    }

    /**
     * @return string
     */
    public function getGetToken()
    {
        return 'sms-auth/get-token';
    }
}