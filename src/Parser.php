<?php

declare(strict_types=1);

namespace MilesChou\Parkdown;

use Illuminate\Contracts\Container\Container;
use MilesChou\Parkdown\Contracts\MarkdownParser;
use MilesChou\Parkdown\Contracts\YamlParser;

class Parser
{
    /**
     * @var Container
     */
    private $container;

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
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->yamlParser = $container->make(YamlParser::class);
        $this->markdownParser = $container->make(MarkdownParser::class);
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

        $regex = '~^(' . $div . "){1}[\r\n|\n]*(.*?)[\r\n|\n]+(" . $div . "){1}[\r\n|\n]*(.*)$~s";

        if (preg_match($regex, $content, $matches) === 1) {
            $yaml = trim($matches[2]);
            $markdown = ltrim($matches[4]);
        }

        return (new Document())
            ->withFrontMatter($this->yamlParser->parse($yaml ?? ''))
            ->withHtml($this->markdownParser->parse($markdown ?? ''));
    }
}
