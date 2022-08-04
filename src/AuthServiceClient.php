<?php

namespace Brezgalov\AuthServiceClient;

use Brezgalov\BaseApiClient\BaseApiClient;
use yii\base\InvalidConfigException;
use yii\httpclient\Request;

class AuthServiceClient extends BaseApiClient
{
    /**
     * @var string
     */
    public $baseUrl;

    /**
     * @var string
     */
    public $appEnvKey;

    /**
     * @var string
     */
    public $activityId;

    /**
     * @var string
     */
    public $adminPublicKey;

    /**
     * @var string
     */
    public $adminSecretKey;

    /**
     * @var Urls
     */
    public $urls;

    /**
     * @var string
     */
    public $adminKeyParam = 'api_key';

    /**
     * @var string
     */
    public $adminPublicKeyParam = 'api_public_key';

    /**
     * @var string
     */
    public $appEnvKeyParameterName = 'app_env_key';

    /**
     * @var string
     */
    public $activityIdParameterName = 'activity_id';

    /**
     * AuthServiceClient constructor.
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->urls)) {
            $this->urls = \Yii::createObject(Urls::class);
        }
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setActivityId(string $value)
    {
        $this->activityId = $value;

        return $this;
    }

    /**
     * @param string $token
     * @return Request
     */
    public function getProfileByTokenRequest(string $token)
    {
        return $this->prepareRequest($this->urls->profile->get, ['token' => $token]);
    }

    /**
     * @param string $phone
     * @param string $smsTextPattern
     * @param string $smsCodeToken
     * @return Request
     */
    public function sendSmsCodeOnPhoneRequest(string $phone, string $smsTextPattern = null, string $smsCodeToken = null)
    {
        $params = ['phone' => $phone];

        if ($smsTextPattern) {
            $params['message_pattern'] = $smsTextPattern;
        }

        if ($smsCodeToken) {
            $params['message_code_token'] = $smsCodeToken;
        }

        return $this->prepareRequest($this->urls->smsAuth->sendCode)
            ->setMethod('POST')
            ->setData($params);
    }

    /**
     * @param string $code
     * @param string $phone
     * @return Request
     */
    public function getTokenBySmsCodeRequest(string $code, string $phone)
    {
        return $this->prepareRequest($this->urls->smsAuth->getTokenByCode)
            ->setMethod('POST')
            ->setData([
                'code' => $code,
                'phone' => $phone
            ]);
    }

    /**
     * @param string $token
     * @param string $refreshToken
     * @return Request
     */
    public function refreshTokenRequest(string $token, string $refreshToken)
    {
        return $this->prepareRequest($this->urls->token->refresh)
            ->setMethod('POST')
            ->setData([
                'token' => $token,
                'refresh_token' => $refreshToken
            ]);
    }

    /**
     * @param string $phone
     * @return \yii\httpclient\Message|Request
     * @throws InvalidConfigException
     */
    public function getTokenByPhoneRequest(string $phone)
    {
        if (empty($this->adminPublicKey)) {
            throw new InvalidConfigException("AdminPublicKey is required");
        }

        if (empty($this->adminSecretKey)) {
            throw new InvalidConfigException("AdminSecretKey is required");
        }

        return $this->prepareRequest($this->urls->admin->getTokenByPhone, [
            $this->adminPublicKeyParam => $this->adminPublicKey,
            $this->adminKeyParam => AdminKeyHelper::getKey(
                $this->adminPublicKey,
                $this->adminSecretKey
            ),
            'phone' => $phone,
        ]);
    }

    /**
     * @param string $route
     * @param array $queryParams
     * @param bool $useAppEnv
     * @param Request|null $request
     * @return \yii\httpclient\Message|Request
     * @throws \yii\base\InvalidConfigException
     */
    public function prepareRequest(string $route, array $queryParams = [], $useAppEnv = true, Request $request = null)
    {
        if ($useAppEnv) {
            $queryParams[$this->appEnvKeyParameterName] = $this->appEnvKey;
        }

        if ($this->activityId) {
            $queryParams[$this->activityIdParameterName] = $this->activityId;
        }

        return parent::prepareRequest($route, $queryParams, $request);
    }
}