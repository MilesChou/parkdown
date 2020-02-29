<?php

declare(strict_types=1);

namespace MilesChou\Parkdown\Block;

use Illuminate\Container\Container;
use MilesChou\Parkdown\Contracts\Block;
use MilesChou\Parkdown\Parser;

class Quote implements Block
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

    public function render(): string
    {
        $quote = (new Container())->make(Parser::class)->parse($this->quote)->html();

        return "<blockquote>{$quote}</blockquote>";
    }
}
