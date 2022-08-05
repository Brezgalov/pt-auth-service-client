<?php

namespace Brezgalov\AuthServiceClient\Urls;

use yii\base\Component;

/**
 * Class AdminUrls
 * @package Brezgalov\AuthServiceClient\Urls
 *
 * @property string $getTokenByPhone
 * @property string $registerUser
 */
class AdminUrls extends Component
{
    public function getGetTokenByPhone()
    {
        return 'admin/get-token-by-phone';
    }

    public function getRegisterUser()
    {
        return 'admin/register-user';
    }
}