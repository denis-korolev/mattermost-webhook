<?php

declare(strict_types=1);

namespace Test\Helpers;

use GuzzleHttp\Psr7\Response;

class Responses
{
    /**
     * @return Response
     */
    public static function successResponse(): Response
    {
        return new Response(
            200,
            [
                'content-type' => 'text/plain',
                'X-Request-Id' => 'kse58tx8r3ftu8ymwzehnoft4h',
                'X-Version-Id' => '5.27.0.5.27.1.ebae422b86b135f696cc67345137d193.false',
                'Date' => 'Fri, 04 Dec 2020 14:10:57 GMT'
            ]
        );
    }

    /**
     * @return Response
     */
    public static function badResponse(): Response
    {
        return new Response(
            400,
            [
                'content-type' => 'text/plain',
                'X-Request-Id' => 'kse58tx8r3ftu8ymwzehnoft4h',
                'X-Version-Id' => '5.27.0.5.27.1.ebae422b86b135f696cc67345137d193.false',
                'Date' => 'Fri, 04 Dec 2020 14:10:57 GMT'
            ]
        );
    }

    /**
     * @return Response
     */
    public static function internalServerErrorResponse(): Response
    {
        return new Response(
            500,
            [
                'content-type' => 'text/plain',
                'X-Request-Id' => 'kse58tx8r3ftu8ymwzehnoft4h',
                'X-Version-Id' => '5.27.0.5.27.1.ebae422b86b135f696cc67345137d193.false',
                'Date' => 'Fri, 04 Dec 2020 14:10:57 GMT'
            ]
        );
    }
}
