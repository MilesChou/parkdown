<?php

namespace MilesChou\Parkdown\Block;

class ParagraphBlock implements BlockInterface
{
    /**
     * @var string
     */
    private $line;

    public function __construct(string $line)
    {
        $this->line = $line;
    }

    public function build(): string
    {
        return "<p>{$this->line}</p>";
    }
}