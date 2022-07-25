<?php

namespace Brezgalov\AuthServiceClient;

use yii\httpclient\Request;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\httpclient\Client;
use yii\httpclient\Response;

class AuthServiceClient extends Model
{
    /**
     * @var string
     */
    public $baseUrl;

    /**
     * @var string
     */
    public $authServiceApiKey;

    /**
     * @var string
     */
    public $activityId;

    /**
     * @var string
     */
    public $pathGetProfileByToken = '/auth/get-profile';

    /**
     * @var string
     */
    public $pathSendSmsCodeOnPhone = '/auth/send-sms';

    /**
     * @var string
     */
    public $pathGetTokenBySmsCode = '/auth/get-token-by-sms';

    /**
     * @var string
     */
    public $pathRefreshTokens = '/auth/get-token-by-refresh';

    /**
     * @var string
     */
    public $authParameterName = 'app_env_key';

    /**
     * @var string
     */
    public $testParameterName = 'is_test';

    /**
     * @var string
     */
    public $activityIdParameterName = 'activity_id';

    /**
     * @var bool
     */
    public $testEnv = false;

    /**
     * @param $value
     * @return $this
     */
    public function setActivityId($value)
    {
        $this->activityId = $value;

        return $this;
    }

    /**
     * @param string $token
     * @return Request
     */
    public function getProfileByTokenRequest($token)
    {
        return $this->getRequest($this->pathGetProfileByToken, ['token' => $token]);
    }

    /**
     * @param string $phone
     * @param string $smsTextPattern
     * @param string $smsCodeToken
     * @return Request
     */
    public function sendSmsCodeOnPhoneRequest($phone, $smsTextPattern = null, $smsCodeToken = null)
    {
        $params = ['phone' => $phone];

        if ($smsTextPattern) {
            $params['message_pattern'] = $smsTextPattern;
        }

        if ($smsCodeToken) {
            $params['message_code_token'] = $smsCodeToken;
        }

        return $this->getRequest($this->pathSendSmsCodeOnPhone, $params);
    }

    /**
     * @param string $code
     * @param string $phone
     * @return Request
     */
    public function getTokenBySmsCodeRequest($code, $phone)
    {
        return $this->getRequest($this->pathGetTokenBySmsCode, [
            'code' => $code,
            'phone' => $phone
        ]);
    }

    /**
     * @param string $token
     * @param string $refreshToken
     * @return Request
     */
    public function refreshTokenRequest($token, $refreshToken)
    {
        return $this->getRequest($this->pathRefreshTokens, [
            'token' => $token,
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * @param string $path
     * @param array $queryParams
     * @param bool $auth
     * @return Request
     */
    public function getRequest($path = '/', $queryParams = [], $auth = true)
    {
        if (!$this->baseUrl) {
            throw new InvalidConfigException('BaseUrl is empty');
        }

        if ($auth) {
            $queryParams[$this->authParameterName] = $this->authServiceApiKey;
        }

        if ($this->testEnv) {
            $queryParams[$this->testParameterName] = 1;
        }

        if ($this->activityId) {
            $queryParams[$this->activityIdParameterName] = $this->activityId;
        }

        $url = "{$this->baseUrl}{$path}?" . http_build_query($queryParams);

        $client = new Client();
        $request = $client->createRequest()->setUrl($url);

        return $request;
    }
}