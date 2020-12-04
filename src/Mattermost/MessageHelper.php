<?php

declare(strict_types=1);

namespace App\Mattermost;

class MessageHelper
{

    /**
     *  Text will add to attachments
     * @param string $attachmentText
     *
     * Attachment title
     * @param string $attachmentTitle
     *
     * @param string $messageText
     *
     * @return Message[]
     */
    public static function createMessagesWithTextAttachments(string $attachmentText, string $attachmentTitle = '', string $messageText = ''): array
    {
        $messages = [];

        $page = 1;
        $textItems = self::makeQuotedText($attachmentText);
        $textItemsCount = count($textItems);

        foreach ($textItems as $item) {
            $prefix = '';
            if ($textItemsCount > 1) {
                $prefix = 'Page ' . $page . '/' . $textItemsCount . '. ';
                $page++;
            }

            $attachment = AttachmentFactory::alertAttachment($attachmentTitle, $item);
            $messages[] = new Message($prefix . $messageText, '', [$attachment]);
        }

        return $messages;
    }

    /**
     * Return array of Text models with text length not more 4000 symbols
     *
     * @param string $text
     * @param int $maximumTextLength
     * @return Text[]
     */
    public static function makeQuotedText(string $text, int $maximumTextLength = 4000): array
    {
        $messages = [];

        $uniqueDelimeter = '<<;>>';
        // 8 symbols for delimeter and quotes
        $reservedLength = 8;

        $chunked = chunk_split($text, $maximumTextLength - $reservedLength, $uniqueDelimeter);
        $textArray = array_filter(explode($uniqueDelimeter, $chunked));

        foreach ($textArray as $item) {
            $messages[] = self::createQuoteText($item);
        }

        return $messages;
    }

    private static function createQuoteText(string $text): Text
    {
        $textObject = new Text();
        $textObject->addLine('```');
        $textObject->addLine($text);
        $textObject->addLine('```');
        return $textObject;
    }

    public static function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
