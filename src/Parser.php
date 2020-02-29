<?php

declare(strict_types=1);

namespace MilesChou\Parkdown;

use Illuminate\Filesystem\Filesystem;
use MilesChou\Parkdown\Contracts\MarkdownParser;
use MilesChou\Parkdown\Contracts\YamlParser;

class Parser
{
    /**
     * @var YamlParser
     */
    private $yamlParser;

    /**
     * @var MarkdownParser
     */
    private $markdownParser;

    /**
     * @var string
     */
    private $div = '---';

    /**
     * @var Filesystem
     */
    private $file;

    /**
     * @param YamlParser $yamlParser
     * @param MarkdownParser $markdownParser
     * @param Filesystem $file
     */
    public function __construct(YamlParser $yamlParser, MarkdownParser $markdownParser, Filesystem $file)
    {
        $this->yamlParser = $yamlParser;
        $this->markdownParser = $markdownParser;
        $this->file = $file;
    }

    /**
     * @param string $div
     */
    public function setDiv(string $div): void
    {
        $this->div = $div;
    }

    /**
     * @param string $content
     * @return Document
     */
    public function parse(string $content): Document
    {
        $splitter = new Splitter($content);

        return (new Document())
            ->withFrontMatter($this->yamlParser->parse($splitter->getYaml() ?? ''))
            ->withHtml($this->markdownParser->parse($splitter->getMarkdown() ?? ''));
    }

    /**
     * @param string $path
     * @return Document
     */
    public function parseFile(string $path): Document
    {
        return $this->parse($this->file->get($path));
    }
}
