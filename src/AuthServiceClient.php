<?php

namespace Brezgalov\AuthServiceClient;

use Brezgalov\BaseApiClient\BaseApiClient;
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
    public $activityIdParameterName = 'activity_id';

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
        return $this->prepareRequest($this->pathGetProfileByToken, ['token' => $token]);
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

        return $this->prepareRequest($this->pathSendSmsCodeOnPhone)
            ->setMethod('POST')
            ->setData($params);
    }

    /**
     * @param string $code
     * @param string $phone
     * @return Request
     */
    public function getTokenBySmsCodeRequest($code, $phone)
    {
        return $this->prepareRequest($this->pathGetTokenBySmsCode)
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
    public function refreshTokenRequest($token, $refreshToken)
    {
        return $this->prepareRequest($this->pathRefreshTokens)
            ->setMethod('POST')
            ->setData([
                'token' => $token,
                'refresh_token' => $refreshToken
            ]);
    }

    /**
     * @param string $route
     * @param array $queryParams
     * @param bool $auth
     * @param Request|null $request
     * @return \yii\httpclient\Message|Request
     * @throws \yii\base\InvalidConfigException
     */
    public function prepareRequest(string $route, array $queryParams = [], $auth = true, Request $request = null)
    {
        if ($auth) {
            $queryParams[$this->authParameterName] = $this->authServiceApiKey;
        }

        if ($this->activityId) {
            $queryParams[$this->activityIdParameterName] = $this->activityId;
        }

        return parent::prepareRequest($route, $queryParams, $request);
    }
}