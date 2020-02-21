<?php

declare(strict_types=1);

namespace MilesChou\Parkdown;

use Illuminate\Contracts\Container\Container;
use Illuminate\Pipeline\Pipeline;
use MilesChou\Parkdown\Block\BlockInterface;
use MilesChou\Parkdown\ParserChains\NullChain;
use MilesChou\Parkdown\ParserChains\ParagraphChain;

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

        $lines = $this->lines($content);

        foreach ($lines as $line) {
            /** @var BlockInterface|null $block */
            $block = (new Pipeline($this->container))->send($line)
                ->through($this->chains)
                ->thenReturn();

            if ($block) {
                $doc->appendBlock($block);
            }
        }

        return $doc;
    }

    /**
     * @param string $content
     * @return iterable<string>
     */
    private function lines(string $content): iterable
    {
        $content = str_replace("\r\n", "\n", $content);

        return explode("\n", $content);
    }
}
