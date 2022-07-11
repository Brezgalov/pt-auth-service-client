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
     * @param $config
     */
    public function __construct($config = [])
    {
        $this->authServiceApiKey = $_ENV['AUTH_SERVICE_API_KEY'] ?? null;
        $this->baseUrl = $_ENV['AUTH_BASE_URL'] ?? null;

        parent::__construct($config);
    }

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
     * @return Response
     */
    public function sendSmsCodeOnPhoneRequest($phone)
    {
        return $this->getRequest($this->pathSendSmsCodeOnPhone, ['phone' => $phone]);
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
     * @return Response
     */
    public function getRequest($path = '/', $queryParams = [])
    {
        if (!$this->baseUrl) {
            throw new InvalidConfigException('BaseUrl is empty');
        }

        if ($this->authServiceApiKey) {
            $queryParams['app_env_key'] = $this->authServiceApiKey;
        }

        $url = $this->baseUrl . $path . '?' . http_build_query($queryParams);

        $client = new Client();
        $request = $client->createRequest()->setUrl($url);

        return $request;
    }
}