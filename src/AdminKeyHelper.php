<?php

namespace Brezgalov\AuthServiceClient;

class AdminKeyHelper
{
    /**
     * @param string $publicKey
     * @param string $secretKey
     * @param int|null $currentTime
     * @return string
     */
    public static function getKey(string $publicKey, string $secretKey, int $currentTime = null)
    {
        if (empty($currentTime)) {
            $currentTime = strtotime(date('Y-m-d H:i:00'));
        }

        return hash('sha256', "{$publicKey}/{$currentTime}/{$secretKey}");
    }
}