<?php

namespace Brezgalov\AuthServiceClient;

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
     * @param string $token
     * @return Response
     */
    public function getProfileByTokenRequest($token)
    {
        return $this->getRequest($this->pathGetProfileByToken, ['token' => $token]);
    }

    /**
     * @param string $phone
     * @param string $smsTextPattern
     * @param string $smsCodeToken
     * @return Response
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
     * @return Response
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
     * @return Response
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
     * @return Response
     */
    public function getRequest($path = '/', $queryParams = [], $auth = true)
    {
        if (!$this->baseUrl) {
            throw new InvalidConfigException('BaseUrl is empty');
        }

        if ($auth) {
            $queryParams[$this->authParameterName] = $this->authServiceApiKey;
        }

        $url = $this->baseUrl . $path . '?' . http_build_query($queryParams);

        $client = new Client();
        $request = $client->createRequest()->setUrl($url);

        return $request;
    }
}