<?php

namespace Brezgalov\AuthServiceClient\ResponseAdapters;

use Brezgalov\BaseApiClient\ResponseAdapters\BaseResponseAdapter;

/**
 * Class AuthResponseAdapter
 * @package Brezgalov\AuthServiceClient\ResponseAdapters
 */
class AuthResponseAdapter extends BaseResponseAdapter
{
    /**
     * @return int|null
     */
    public function getAuthId()
    {
        return $this->responseData['user_id'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPhone()
    {
        return $this->responseData['phone'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getToken()
    {
        return $this->responseData['token'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getTokenExpiresAt()
    {
        return $this->responseData['token_expires_at'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken()
    {
        return $this->responseData['refresh_token'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getRefreshTokenExpiresAt()
    {
        return $this->responseData['refresh_token_expires_at'] ?? null;
    }
}