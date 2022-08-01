<?php

namespace Brezgalov\AuthServiceClient\Urls;

use yii\base\Component;

/**
 * Class AdminUrls
 * @package Brezgalov\AuthServiceClient\Urls
 *
 * @property string getTokenByPhone
 */
class AdminUrls extends Component
{
    public function getGetTokenByPhone()
    {
        return 'admin/get-token-by-phone';
    }
}