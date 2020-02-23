<?php

declare(strict_types=1);

namespace MilesChou\Parkdown\Parser;

use MilesChou\Parkdown\Block\Quote;
use MilesChou\Parkdown\Context;
use MilesChou\Parkdown\Contracts\Block;
use MilesChou\Parkdown\Contracts\Parser;

/**
 * @see https://daringfireball.net/projects/markdown/syntax#precode
 */
class QuoteParser implements Parser
{
    public function handle(Context $context, callable $next): ?Block
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

    protected function buildBlock(Context $context): Block
    {
        $block = new Quote();

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
