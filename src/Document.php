<?php

declare(strict_types=1);

namespace MilesChou\Parkdown;

/**
 * Container with parsed result
 */
class Document
{
    /**
     * @var array<mixed>
     */
    private $frontMatter = [];

    /**
     * @var string
     */
    private $html = '';

    /**
     * @return array<mixed>
     */
    public function frontMatter(): array
    {
        return $this->frontMatter;
    }

    public function html(): string
    {
        return $this->html;
    }

    /**
     * @param array<mixed> $frontMatter
     * @return Document
     */
    public function withFrontMatter(array $frontMatter): Document
    {
        $this->frontMatter = $frontMatter;
        return $this;
    }

    /**
     * @param string $html
     * @return Document
     */
    public function withHtml(string $html): Document
    {
        $this->html = $html;
        return $this;
    }
}
