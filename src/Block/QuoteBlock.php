<?php

namespace MilesChou\Parkdown\Block;

class QuoteBlock implements BlockInterface
{
    /**
     * @var string
     */
    private $quote = '';

    /**
     * @param array<string> $lines
     */
    public function __construct(array $lines = [])
    {
        $this->addLines($lines);
    }

    public function addLine(string $line): void
    {
        $this->quote .= substr($line, 2) . PHP_EOL;
    }

    /**
     * @param array<string> $lines
     */
    public function addLines(array $lines): void
    {
        foreach ($lines as $line) {
            $this->addLine($line);
        }
    }

    public function html(): string
    {
        return "<blockquote>{$this->quote}</blockquote>";
    }
}