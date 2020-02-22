<?php

declare(strict_types=1);

namespace MilesChou\Parkdown;

use Illuminate\Contracts\Container\Container;
use Illuminate\Pipeline\Pipeline;
use MilesChou\Parkdown\Block\BlockInterface;
use MilesChou\Parkdown\Parser\Chain\CodeChain;
use MilesChou\Parkdown\Parser\Chain\NullChain;
use MilesChou\Parkdown\Parser\Chain\ParagraphChain;
use MilesChou\Parkdown\Parser\Chain\QuoteChain;
use MilesChou\Parkdown\Parser\Context;

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
        QuoteChain::class,
        CodeChain::class,
        ParagraphChain::class,
        NullChain::class,
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
            /** @var BlockInterface|null $block */
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
