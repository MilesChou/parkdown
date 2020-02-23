<?php

namespace MilesChou\Parkdown\Parser\Chain;

use MilesChou\Parkdown\Block\BlockInterface;
use MilesChou\Parkdown\Block\CodeBlock;
use MilesChou\Parkdown\Block\QuoteBlock;
use MilesChou\Parkdown\Parser\Context;

/**
 * @see https://daringfireball.net/projects/markdown/syntax#precode
 */
class QuoteChain implements ChainInterface
{
    public function handle(Context $context, callable $next): ?BlockInterface
    {
        $line = $context->current();

        if ($this->isQuoteBlock($line)) {
            return $this->buildBlock($context);
        }

        return $next($context);
    }

    private function isQuoteBlock(string $line): bool
    {
        return strpos($line, '> ') === 0 || strpos($line, '>') === 0;
    }

    protected function buildBlock(Context $context): BlockInterface
    {
        $block = new QuoteBlock();

        while ($context->valid()) {
            $line = $context->current();

            if ($this->isQuoteBlock($line)) {
                $block->addLine($line);
            }

            // Stop at empty line
            if (empty(trim($line))) {
                break;
            }

            $context->next();
        }

        return $block;
    }
}
