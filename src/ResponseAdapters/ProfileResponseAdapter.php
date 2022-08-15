<?php

namespace Brezgalov\AuthServiceClient\ResponseAdapters;

class ProfileResponseAdapter extends BaseResponseAdapter
{
    /**
     * @return int|null
     */
    public function getAuthId()
    {
        return $this->responseData['id'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getLogin()
    {
        return $this->responseData['login'] ?? null;
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
    public function getCreatedAt()
    {
        return $this->responseData['created_at'] ?? null;
    }
}