<?php

declare(strict_types=1);

namespace MilesChou\Parkdown;

use Illuminate\Contracts\Container\Container;
use Illuminate\Pipeline\Pipeline;
use MilesChou\Parkdown\Block\Document;
use MilesChou\Parkdown\Contracts\Block;
use MilesChou\Parkdown\Parser\CodeParser;
use MilesChou\Parkdown\Parser\NullParser;
use MilesChou\Parkdown\Parser\ParagraphParser;
use MilesChou\Parkdown\Parser\QuoteParser;

class Parser
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var array<string>
     */
    private $chains = [
        QuoteParser::class,
        CodeParser::class,
        ParagraphParser::class,
        NullParser::class,
    ];

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function parse(string $content): Document
    {
        $doc = new Document();

        $context = new Context($content);

        while ($context->valid()) {
            /** @var Block|null $block */
            $block = (new Pipeline($this->container))->send($context)
                ->through($this->chains)
                ->thenReturn();

            if ($block) {
                $doc->appendBlock($block);
            }

            $context->next();
        }

        return $doc;
    }
}
