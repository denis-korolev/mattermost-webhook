<?php

declare(strict_types=1);

namespace Test\Unit\Mattermost;

use App\Mattermost\Attachment;
use App\Mattermost\WebhookClient;
use App\Mattermost\Message;
use App\Mattermost\WebhookParams;
use PHPUnit\Framework\TestCase;
use Test\Helpers\MockResponseHelper;
use Test\Helpers\Responses;

class ClientTest extends TestCase
{

    public function testSuccessRequest(): void
    {
        /** @codingStandardsIgnoreStart Generic.Files.LineLength */
        $attachment = (new Attachment())->setFallback('This is the fallback test for the attachment.')
            ->setSuccessColor();
        /** @codingStandardsIgnoreEnd */

        $message = new Message('Testing', '', [$attachment]);

        $mockClient = MockResponseHelper::createClient(
            [
                Responses::successResponse()
            ]
        );
        $params = new WebhookParams('http://matermost:8065/hooks/dui7ons8et8sxpuhdxxj4todfw', 'town-square', 'test');

        $client = new WebhookClient($mockClient, $params);
        $client->send($message);

        self::assertTrue(true);
    }

    public function testBadRequest(): void
    {
        /** @codingStandardsIgnoreStart Generic.Files.LineLength */
        $attachment = (new Attachment())->setFallback('This is the fallback test for the attachment.')
            ->setSuccessColor();
        /** @codingStandardsIgnoreEnd */

        $message = new Message('Testing', '', [$attachment]);

        $mockClient = MockResponseHelper::createClient(
            [
                Responses::badResponse()
            ]
        );
        $params = new WebhookParams('http://matermost:8065/hooks/dui7ons8et8sxpuhdxxj4todfw', 'town-square', 'test');

        $client = new WebhookClient($mockClient, $params);

        $this->expectExceptionMessage('Error while send request: Bad Request');

        $client->send($message);
    }

    public function testServerErrorResponse(): void
    {
        /** @codingStandardsIgnoreStart Generic.Files.LineLength */
        $attachment = (new Attachment())->setFallback('This is the fallback test for the attachment.')
            ->setSuccessColor();
        /** @codingStandardsIgnoreEnd */

        $message = new Message('Testing', '', [$attachment]);

        $mockClient = MockResponseHelper::createClient(
            [
                Responses::internalServerErrorResponse()
            ]
        );
        $params = new WebhookParams('http://matermost:8065/hooks/dui7ons8et8sxpuhdxxj4todfw', 'town-square', 'test');

        $client = new WebhookClient($mockClient, $params);

        $this->expectExceptionMessage('Error while send request: Internal Server Error');

        $client->send($message);
    }
}
