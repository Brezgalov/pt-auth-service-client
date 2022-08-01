<?php

namespace Brezgalov\AuthServiceClient\Urls;

use yii\base\Component;

/**
 * Class AuthUrls
 * @package Brezgalov\AuthServiceClient\Urls
 *
 * @property string getProfileByToken
 * @property string sendSmsCodeOnPhone
 * @property string getTokenBySmsCode
 * @property string refreshTokens
 */
class AuthUrls extends Component
{
    /**
     * @return string
     */
    public function getGetProfileByToken()
    {
        return 'auth/get-profile';
    }

    /**
     * @return string
     */
    public function getSendSmsCodeOnPhone()
    {
        return 'auth/send-sms';
    }

    /**
     * @return string
     */
    public function getGetTokenBySmsCode()
    {
        return 'auth/get-token-by-sms';
    }

    /**
     * @return string
     */
    public function getRefreshTokens()
    {
        return 'auth/get-token-by-refresh';
    }
}