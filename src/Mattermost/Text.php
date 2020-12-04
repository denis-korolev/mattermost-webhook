<?php

declare(strict_types=1);

namespace App\Mattermost;

final class Text
{
    private array $lines = [];

    public function addLine(string $line): void
    {
        $this->lines[] = trim($line);
    }

    /**
     * @param string[] $text
     */
    public function setText(array $text): void
    {
        $this->lines = array_map('trim', $text);
    }

    public function getText(): string
    {
        return implode("\n", $this->lines);
    }
}
