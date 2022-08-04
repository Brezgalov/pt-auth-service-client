<?php

namespace Brezgalov\AuthServiceClient\Urls;

use yii\base\Component;

/**
 * Class AuthUrls
 * @package Brezgalov\AuthServiceClient\Urls
 *
 * @property string $refresh
 */
class TokenUrls extends Component
{
    /**
     * @return string
     */
    public function getRefresh()
    {
        return 'token/refresh';
    }
}