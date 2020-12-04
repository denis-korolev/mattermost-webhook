<?php

namespace App\Mattermost;

use Nyholm\Psr7\Request;
use Nyholm\Psr7\Uri;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

final class WebhookClient implements MattermostClientInterface
{
    private ClientInterface $client;

    private WebhookParams $webhookParams;

    public function __construct(ClientInterface $client, WebhookParams $webhookParams)
    {
        $this->client = $client;
        $this->webhookParams = $webhookParams;
    }

    public function send(Message $message): void
    {
        $requestPayload = $message->toArray();

        $requestPayload['channel'] = $this->webhookParams->getChannel();
        $requestPayload['username'] = $this->webhookParams->getUsername();

        $request = new Request(
            'POST',
            new Uri($this->webhookParams->getWebHookUrl()),
            [
                'Content-Type' => 'application/json'
            ],
            json_encode($requestPayload, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING | JSON_UNESCAPED_UNICODE)
        );

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new MattermostException('Mattermost client exception while sendRequest : ' . $e->getMessage());
        }

        if (!$this->isOk($response)) {
            throw new MattermostException('Error while send request: ' . $response->getReasonPhrase());
        }
    }

    private function isOk(ResponseInterface $rsp): bool
    {
        return $rsp->getStatusCode() >= 200 && $rsp->getStatusCode() < 300;
    }

    public function batchSend(Message ...$message): void
    {
        foreach ($message as $item) {
            $this->send($item);
        }
    }
}
