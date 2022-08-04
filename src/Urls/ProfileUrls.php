<?php

namespace Brezgalov\AuthServiceClient\Urls;

use yii\base\Component;

/**
 * Class ProfileUrls
 * @package Brezgalov\AuthServiceClient\Urls
 *
 * @property string $get
 */
class ProfileUrls extends Component
{
    /**
     * @return string
     */
    public function getGet()
    {
        return 'profile/get';
    }
}