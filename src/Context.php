<?php

declare(strict_types=1);

namespace MilesChou\Parkdown;

use Iterator;

/**
 * @implements \Iterator<string>
 */
class Context implements Iterator
{
    /**
     * @var array<string>
     */
    private $lines;

    /**
     * @var int
     */
    private $current = 0;

    /**
     * @param string $content Markdown content
     */
    public function __construct(string $content)
    {
        $this->lines = $this->splitLines($content);
    }

    public function clone(): Context
    {
        return clone $this;
    }

    /**
     * @return array<string>
     */
    public function toArray(): array
    {
        return $this->lines;
    }

    /**
     * @param string $content
     * @return array<string>
     */
    private function splitLines(string $content): array
    {
        $content = str_replace(["\r\n", "\r"], "\n", $content);

        return explode("\n", $content);
    }

    /**
     * @inheritDoc
     */
    public function current(): string
    {
        return $this->lines[$this->current];
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        $this->current++;
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->current;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return isset($this->lines[$this->current]);
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->current = 0;
    }
}
