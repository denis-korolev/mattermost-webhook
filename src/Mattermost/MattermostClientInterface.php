<?php

namespace App\Mattermost;

interface MattermostClientInterface
{
    public function send(Message $message): void;
    public function batchSend(Message ...$message): void;
}
