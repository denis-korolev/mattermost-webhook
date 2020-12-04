<?php

namespace App\Mattermost;

final class AttachmentFactory
{
    public static function alertAttachment(string $attachmentPretext, Text $description): Attachment
    {
        return (new Attachment())
            ->setErrorColor()
            ->setPretext($attachmentPretext)
            ->setText($description->getText());
    }

    public static function successAttachment(string $attachmentPretext, Text $description): Attachment
    {
        return (new Attachment())
            ->setSuccessColor()
            ->setPretext($attachmentPretext)
            ->setText($description->getText());
    }
}
