<?php

namespace Brezgalov\AuthServiceClient;

use Brezgalov\AuthServiceClient\Urls\AdminUrls;
use Brezgalov\AuthServiceClient\Urls\AuthUrls;
use Brezgalov\AuthServiceClient\Urls\ProfileUrls;
use Brezgalov\AuthServiceClient\Urls\SmsAuthUrls;
use Brezgalov\AuthServiceClient\Urls\TokenUrls;
use yii\base\Component;

/**
 * Class Urls
 * @package Brezgalov\AuthServiceClient
 */
class Urls extends Component
{
    /**
     * @var AdminUrls
     */
    public $admin;

    /**
     * @var TokenUrls
     */
    public $token;

    /**
     * @var SmsAuthUrls
     */
    public $smsAuth;

    /**
     * @var ProfileUrls
     */
    public $profile;

    /**
     * Urls constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->admin)) {
            $this->admin = \Yii::createObject(AdminUrls::class);
        }

        if (empty($this->profile)) {
            $this->profile = \Yii::createObject(ProfileUrls::class);
        }

        if (empty($this->token)) {
            $this->token = \Yii::createObject(TokenUrls::class);
        }

        if (empty($this->smsAuth)) {
            $this->smsAuth = \Yii::createObject(ProfileUrls::class);
        }
    }
}