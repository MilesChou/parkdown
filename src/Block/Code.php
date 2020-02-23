<?php

declare(strict_types=1);

namespace MilesChou\Parkdown\Block;

use MilesChou\Parkdown\Contracts\Block;

class Code implements Block
{
    /**
     * @var string
     */
    private $code = '';

    /**
     * @param array<string> $lines
     */
    public function __construct(array $lines = [])
    {
        $this->addLines($lines);
    }

    public function addLine(string $line): void
    {
        if ("\t" === $line[0]) {
            $this->code .= substr($line, 1) . PHP_EOL;
        } else {
            $this->code .= substr($line, 4) . PHP_EOL;
        }
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
        return "<pre><code>{$this->code}</code></pre>";
    }
}
