<?php

declare(strict_types=1);

namespace Test\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class MockResponseHelper
{
    /**
     * @param ResponseInterface[] $responses
     * @return ClientInterface
     */
    public static function createClient(array $responses): ClientInterface
    {
        /** @psalm-suppress MixedArgumentTypeCoercion */
        $mock = new MockHandler($responses);

        $handlerStack = HandlerStack::create($mock);
        return new Client(['handler' => $handlerStack]);
    }
}
