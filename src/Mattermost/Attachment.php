<?php

namespace App\Mattermost;

final class Attachment
{
    /**
     * A required plain-text summary of the post. This is used in notifications, and in clients that don’t support formatted text (eg IRC).
     */
    private string $fallback = '';

    /**
     * A hex color code that will be used as the left border color for the attachment. If not specified, it will default to match the left hand sidebar header background color.
     */
    private string $color = '';

    /**
     * An optional line of text that will be shown above the attachment.
     */
    private string $pretext = '';

    /**
     * The text to be included in the attachment. It can be formatted using markdown.
     * If it includes more than 700 characters or more than 5 line breaks, the message will be collapsed and a “Show More” link will be added to expand the message.
     */
    private string $text = '';

    /**
     * An optional name used to identify the author. It will be included in a small section at the top of the attachment.
     */
    private string $authorName = '';

    /**
     * An optional URL used to hyperlink the author_name. If no author_name is specified, this field does nothing.
     */
    private string $authorLink = '';

    /**
     * An optional URL used to display a 16x16 pixel icon beside the author_name.
     */
    private string $authorIcon = '';

    /**
     * An optional title displayed below the author information in the attachment.
     */
    private string $title = '';

    /**
     * An optional URL used to hyperlink the title. If no title is specified, this field does nothing.
     */
    private string $titleLink = '';

    /**
     * Fields can be included as an optional array within attachments, and are used to display information in a table format inside the attachment.
     */
    private array $fields = [];

    /**
     * An optional URL to an image file (GIF, JPEG, PNG, or BMP) that will be displayed inside a message attachment.
     * Large images will be resized to a maximum width of 400px or a maximum height of 300px, while still maintaining the original aspect ratio.
     */
    private string $imageUrl = '';

    /**
     * An optional URL to an image file (GIF, JPEG, PNG, or BMP) that will be displayed as a 75x75 pixel thumbnail on the right side of an attachment.
     * We recommend using an image that is already 75x75 pixels, but larger images will be scaled down with the aspect ratio maintained.
     */
    private string $thumbUrl = '';

    /**
     * Optional actions that can be made when responding to an incoming attachment. Should be an array that includes:
     * 'name' string Title of an action button (ex. Verify)
     * 'integration' array:
     *      'url' string URL where the action will be sent (ex. https://opt.netis.pl/mattermost/verify-request)
     *      'context' array: include any parameters that will be sent to the URL (ex. ['text' => 123456]
     */
    private array $actions = [];

    public function setFallback(string $fallback): self
    {
        $this->fallback = $fallback;

        return $this;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Set a green color for the attachment.
     */
    public function setSuccessColor(): self
    {
        $this->color = '#22BC66';

        return $this;
    }

    /**
     * Set a red color for the attachment.
     */
    public function setErrorColor(): self
    {
        $this->color = '#DC4D2F';

        return $this;
    }

    /**
     * Set a blue color for the attachment.
     */
    public function setInfoColor(): self
    {
        $this->color = '#3869D4';

        return $this;
    }

    public function setPretext(string $pretext): self
    {
        $this->pretext = $pretext;

        return $this;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function setAuthorLink(string $authorLink): self
    {
        $this->authorLink = $authorLink;

        return $this;
    }

    public function setAuthorIcon(string $authorIcon): self
    {
        $this->authorIcon = $authorIcon;

        return $this;
    }

    public function setTitle(string $title, string $titleLink = ''): self
    {
        $this->title = $title;
        $this->titleLink = $titleLink;

        return $this;
    }

    public function setFields(array $fields = []): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Add a field to the attachment
     *
     * @param string $title A title shown in the table above the value.
     * @param string $value The text value of the field. It can be formatted using markdown.
     * @param bool $short Optionally set to “True” or “False” to indicate whether the value is short enough to be displayed beside other values.
     * @return $this
     */
    public function addField(string $title, string $value, $short = true): self
    {
        $this->fields[] = [
            'title' => $title,
            'value' => $value,
            'short' => $short,
        ];

        return $this;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function setThumbUrl(string $thumbUrl): self
    {
        $this->thumbUrl = $thumbUrl;

        return $this;
    }

    public function addAction(array $action): self
    {
        $this->actions[] = $action;

        return $this;
    }

    public function setActions(array $actions): self
    {
        $this->actions = $actions;

        return $this;
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'fallback' => $this->fallback,
                'color' => $this->color,
                'pretext' => $this->pretext,
                'text' => $this->text,
                'author_name' => $this->authorName,
                'author_link' => $this->authorLink,
                'author_icon' => $this->authorIcon,
                'title' => $this->title,
                'title_link' => $this->titleLink,
                'fields' => $this->fields,
                'image_url' => $this->imageUrl,
                'thumb_url' => $this->thumbUrl,
                'actions' => $this->actions,
            ]
        );
    }
}
