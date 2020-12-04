<?php

declare(strict_types=1);

namespace Test\Unit\Mattermost;

use App\Mattermost\MessageHelper;
use PHPUnit\Framework\TestCase;

class MessageHelperTest extends TestCase
{
    public function testMakeQuotedMessages(): void
    {
        $randomString = MessageHelper::generateRandomString(20);

        $texts = MessageHelper::makeQuotedText($randomString, 30);
        self::assertCount(1, $texts);
        $text = $texts[0];

        self::assertEquals('```', mb_substr($text->getText(), 0, 3));
        self::assertEquals('```', mb_substr($text->getText(), -3));
        // Длина текста получается 20 символов + 8 символов на кавычки и один перенос
        self::assertSame(28, strlen($text->getText()));

        $randomString = MessageHelper::generateRandomString(30);
        $texts = MessageHelper::makeQuotedText($randomString, 10);
        self::assertCount(15, $texts);
        $text = $texts[0];
        self::assertEquals('```', mb_substr($text->getText(), 0, 3));
        self::assertEquals('```', mb_substr($text->getText(), -3));
        self::assertSame(10, strlen($text->getText()));


        $randomString = MessageHelper::generateRandomString(6000);
        $texts = MessageHelper::makeQuotedText($randomString);
        self::assertCount(2, $texts);
        $text = $texts[0];

        self::assertEquals('```', mb_substr($text->getText(), 0, 3));
        self::assertEquals('```', mb_substr($text->getText(), -3));
        self::assertSame(4000, strlen($text->getText()));

        $nextText = $texts[1];
        // 8 символов от первой партии и 8 от второй превратились в 2000+16
        self::assertSame(2016, strlen($nextText->getText()));
    }

    public function testCreateMessagesWithTextAttachments(): void
    {

        $messages = MessageHelper::createMessagesWithTextAttachments('hi', '', 'text');

        /** @psalm-suppress MixedArgument */
        self::assertCount(1, $messages);
        /**
         * @psalm-suppress  MixedArrayAccess
         * @psalm-var array{
         *       text: string,
         *       attachments: array{array{text:string}}
         * } $messageData
         */
        $messageData = $messages[0]->toArray();
        self::assertEquals('text', $messageData['text']);
        self::assertCount(1, $messageData['attachments']);
        self::assertEquals("```\nhi\n```", $messageData['attachments'][0]['text']);
    }
}
