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
     * @param string $content
     * @return Document
     */
    public function parse(string $content): Document
    {
        $splitter = new Splitter($content);

        $document = new Document();

        if ($splitter->hasYaml()) {
            $yaml = (string)$splitter->getYaml();
            $document = $document->withFrontMatter($this->yamlParser->parse($yaml));
        }

        if ($splitter->hasMarkdown()) {
            $markdown = (string)$splitter->getMarkdown();
            $document = $document->withHtml($this->markdownParser->parse($markdown));
        }

        return $document;
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
