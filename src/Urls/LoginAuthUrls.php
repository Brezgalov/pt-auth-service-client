<?php

namespace Brezgalov\AuthServiceClient\Urls;

use yii\base\Component;

/**
 * Class LoginAuthUrls
 * @package Brezgalov\AuthServiceClient\Urls
 *
 * @property string $getToken
 */
class LoginAuthUrls extends Component
{
    /**
     * @return string
     */
    public function getGetToken()
    {
        return 'login-auth/get-token';
    }
}