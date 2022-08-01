<?php

namespace Brezgalov\AuthServiceClient;

use Brezgalov\AuthServiceClient\Urls\AdminUrls;
use Brezgalov\AuthServiceClient\Urls\AuthUrls;
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
     * @var AuthUrls
     */
    public $auth;

    /**
     * Urls constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->admin)) {
            $this->admin = new AdminUrls();
        }

        if (empty($this->auth)) {
            $this->auth = new AuthUrls();
        }
    }
}