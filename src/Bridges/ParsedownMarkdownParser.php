<?php

namespace MilesChou\Parkdown\Bridges;

use MilesChou\Parkdown\Contracts\MarkdownParser;
use Parsedown as Parser;

class ParsedownMarkdownParser implements MarkdownParser
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function parse(string $markdown): string
    {
        return $this->parser->parse($markdown);
    }
}
