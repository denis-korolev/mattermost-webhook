<?php

namespace App\Mattermost;

final class Message
{
    /**
     * The text of the message.
     */
    private string $text;

    /**
     * The icon of the message.
     */
    private string $iconUrl;

    /**
     * The attachments of the message.
     * @var Attachment[]
     */
    private array $attachments;

    /**
     * @param string $text
     * @param string $iconUrl
     * @param Attachment[] $attachments
     */
    public function __construct(string $text, string $iconUrl = '', array $attachments = [])
    {
        $this->text = $text;
        $this->iconUrl = $iconUrl;
        $this->attachments = $attachments;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function setIconUrl(string $iconUrl): self
    {
        $this->iconUrl = $iconUrl;

        return $this;
    }

    /**
     * Override all attachments for the message.
     *
     * @param Attachment[] $attachments
     * @return $this
     */
    public function setAttachments($attachments = []): self
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * Add an attachment for the message
     * @param Attachment $attachment
     * @return Message
     */
    public function addAttachment(Attachment $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'text' => $this->text,
                'icon_url' => $this->iconUrl,
                'attachments' => array_map(
                    static function (Attachment $attachment) {
                        return $attachment->toArray();
                    },
                    $this->attachments
                ),
            ]
        );
    }
}
