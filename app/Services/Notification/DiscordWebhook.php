<?php

namespace App\Services\Notification;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class DiscordWebhook implements NotificationService
{
    private const DISCORD_WEBHOOK_URL = 'https://discord.com/api/webhooks/1034853065171406959/nt8h6SGXCt7v6-ObvVCg_xHBf1hO4OY2qRAq9nccpjIT-VL7a-s8wlmgVzE5IFAAChm9';
    private const SUCCESS_COLOR = '65372';
    private const ERROR_COLOR = '16711680';
    private const WARNING_COLOR = '16776960';
    private const INFO_COLOR = '5596137';


    public function send(?string $theme = null, string $body): Response
    {
        return Http::post(self::DISCORD_WEBHOOK_URL, $this->template(theme: $theme, body: $body));
    }

    private function template(?string $theme = null, string $body): array 
    {
        $theme = $this->themeSelector($theme);

        return [
            'content' => null,
            'embeds' => [
                [
                    'title' => $theme['title'],
                    'description' => $body,
                    'color' => $theme['color'],
                    'fields' => [
                        [
                            'name' => "Timestamp",
                            'value' => Carbon::now()->toDateTimeString(),
                        ]
                    ],
                    'author' => [
                        'name' => "Ambiente: " . env('APP_ENV'),
                        'url' => env('APP_URL'),
                    ]
                ]
            ],
        ];
    }

    private function themeSelector(?string $theme): array
    {
        switch ($theme) {
            case 'success':
                return [
                    "title" => "✅ Dataprag Notification",
                    "color" => self::SUCCESS_COLOR
                ];
            case 'error':
                return [
                    "title" => "❌ Dataprag Notification",
                    "color" => self::ERROR_COLOR
                ];
            case 'warning':
                return [
                    "title" => "⚠️ Dataprag Notification",
                    "color" => self::WARNING_COLOR
                ];
            
            default:
                return [
                    "title" => "ℹ️ Dataprag Notification",
                    "color" => self::INFO_COLOR
                ];
        }

    }
}