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
        $div = preg_quote($this->div, '~');

        $regex = '~^' .
            '(' . $div . '){1}' .       // $matches[1] match `---`
            "[\r\n|\n]*" .
            '(.*?)' .                   // $matches[2] match YAML content
            "[\r\n|\n]+" .
            '(' . $div . '){1}' .       // $matches[3] match `---`
            "[\r\n|\n]*" .
            '(.*)' .                    // $matches[4] match Markdown content
            '$~s';

        if (preg_match($regex, $content, $matches) === 1) {
            $yaml = trim($matches[2]);
            $markdown = ltrim($matches[4]);
        }

        return (new Document())
            ->withFrontMatter($this->yamlParser->parse($yaml ?? ''))
            ->withHtml($this->markdownParser->parse($markdown ?? ''));
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
