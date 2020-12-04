<?php

declare(strict_types=1);

namespace App\Mattermost;

use Webmozart\Assert\Assert;

class WebhookParams
{
    private string $webHookUrl;
    private string $channel;
    private string $username;

    public function __construct(string $webHookUrl, string $channel, string $username)
    {
        Assert::notEmpty($webHookUrl);
        Assert::notFalse(filter_var($webHookUrl, FILTER_VALIDATE_URL), 'Not valid Webhook URL');

        Assert::notEmpty($channel);
        Assert::notEmpty($username);

        $this->webHookUrl = $webHookUrl;
        $this->channel = $channel;
        $this->username = $username;
    }

    public function getWebHookUrl(): string
    {
        return $this->webHookUrl;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
