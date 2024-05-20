<?php

namespace App\Services\Notification;

interface NotificationService
{
    public function send(?string $theme, string $body);
}