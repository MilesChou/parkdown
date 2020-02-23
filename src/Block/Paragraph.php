<?php

declare(strict_types=1);

namespace MilesChou\Parkdown\Block;

use MilesChou\Parkdown\Contracts\Block;

class Paragraph implements Block
{
    /**
     * @var string
     */
    private $line;

    public function __construct(string $line)
    {
        $this->line = $line;
    }

    public function render(): string
    {
        return "<p>{$this->line}</p>";
    }
}
