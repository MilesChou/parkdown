<?php

namespace MilesChou\Parkdown;

class Document
{
    /**
     * @var array<mixed>
     */
    private $frontMatter;

    /**
     * @var string
     */
    private $html;

    /**
     * @return array<mixed>|null
     */
    public function frontMatter(): ?array
    {
        return $this->frontMatter;
    }

    public function html(): string
    {
        return $this->html;
    }

    /**
     * @param mixed $frontMatter
     * @return Document
     */
    public function withFrontMatter($frontMatter): Document
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
