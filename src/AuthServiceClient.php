<?php

namespace Brezgalov\AuthServiceClient;

use Brezgalov\AuthServiceClient\ResponseAdapters\AuthResponseAdapter;
use Brezgalov\AuthServiceClient\ResponseAdapters\ProfileResponseAdapter;
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
     * @deprecated
     * @see AuthServiceClient::getProfileByToken
     *
     * @param string $token
     * @return Request
     */
    public function getProfileByTokenRequest(string $token)
    {
        return $this->prepareRequest($this->urls->profile->get, ['token' => $token]);
    }

    /**
     * @param string $token
     * @return ProfileResponseAdapter
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getProfileByToken(string $token)
    {
        $request = $this->prepareRequest($this->urls->profile->get, ['token' => $token]);

        return new ProfileResponseAdapter($request, $request->send());
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
     * @deprecated
     * @see AuthServiceClient::getTokenBySmsCode
     *
     * @param string $code
     * @param string $phone
     * @return Request
     */
    public function getTokenBySmsCodeRequest(string $code, string $phone)
    {
        return $this->prepareRequest($this->urls->smsAuth->getToken)
            ->setMethod('POST')
            ->setData([
                'code' => $code,
                'phone' => $phone
            ]);
    }

    /**
     * @param string $code
     * @param string $phone
     * @return AuthResponseAdapter
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getTokenBySmsCode(string $code, string $phone)
    {
        $request = $this->prepareRequest($this->urls->smsAuth->getToken)
            ->setMethod('POST')
            ->setData([
                'code' => $code,
                'phone' => $phone
            ]);

        return new AuthResponseAdapter($request, $request->send());
    }

    /**
     * @deprecated
     * @see AuthServiceClient::refreshToken
     *
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
     * @param string $token
     * @param string $refreshToken
     * @return AuthResponseAdapter
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function refreshToken(string $token, string $refreshToken)
    {
        $request = $this->prepareRequest($this->urls->token->refresh)
            ->setMethod('POST')
            ->setData([
                'token' => $token,
                'refresh_token' => $refreshToken
            ]);

        return new AuthResponseAdapter($request, $request->send());
    }

    /**
     * @deprecated
     * @see AuthServiceClient::getTokenByPhone
     *
     * @param string $phone
     * @return \yii\httpclient\Message|Request
     * @throws InvalidConfigException
     */
    public function getTokenByPhoneRequest(string $phone)
    {
        $params = $this->buildAdminRequestQueryParams();
        $params['phone'] = $phone;

        return $this->prepareRequest($this->urls->admin->getTokenByPhone, $params);
    }

    /**
     * @param string $phone
     * @return AuthResponseAdapter
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getTokenByPhone(string $phone)
    {
        $params = $this->buildAdminRequestQueryParams();
        $params['phone'] = $phone;

        $request = $this->prepareRequest($this->urls->admin->getTokenByPhone, $params);

        return new AuthResponseAdapter($request, $request->send());
    }

    /**
     * @param string $phone
     * @param string|null $login
     * @param string|null $password
     * @return \yii\httpclient\Message|Request
     * @throws InvalidConfigException
     */
    public function getRegisterUserRequest(string $phone, string $login = null, string $password = null)
    {
        $params = $this->buildAdminRequestQueryParams();

        return $this->prepareRequest($this->urls->admin->registerUser, $params)
            ->setMethod('POST')
            ->setData([
                'phone' => $phone,
                'login' => $login,
                'password' => $password,
            ]);
    }

    /**
     * @deprecated
     * @see AuthServiceClient::getTokenByLoginAndPass
     *
     * @param string $login
     * @param string $password
     * @return \yii\httpclient\Message|Request
     * @throws InvalidConfigException
     */
    public function getTokenByLoginAndPassRequest(string $login,string $password)
    {
        return $this->prepareRequest($this->urls->loginAuth->getToken)
            ->setMethod('POST')
            ->setData([
                'login' => trim($login),
                'password' => trim($password),
            ]);
    }

    /**
     * @param string $login
     * @param string $password
     * @return AuthResponseAdapter
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getTokenByLoginAndPass(string $login,string $password)
    {
        $request = $this->prepareRequest($this->urls->loginAuth->getToken)
            ->setMethod('POST')
            ->setData([
                'login' => trim($login),
                'password' => trim($password),
            ]);

        return new AuthResponseAdapter($request, $request->send());
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

    /**
     * @return array
     * @throws InvalidConfigException
     */
    protected function buildAdminRequestQueryParams()
    {
        if (empty($this->adminPublicKey)) {
            throw new InvalidConfigException("AdminPublicKey is required");
        }

        if (empty($this->adminSecretKey)) {
            throw new InvalidConfigException("AdminSecretKey is required");
        }

        return [
            $this->adminPublicKeyParam => $this->adminPublicKey,
            $this->adminKeyParam => AdminKeyHelper::getKey(
                $this->adminPublicKey,
                $this->adminSecretKey
            ),
        ];
    }
}