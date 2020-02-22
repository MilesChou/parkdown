<?php

namespace MilesChou\Parkdown\Parser\Chain;

use MilesChou\Parkdown\Block\BlockInterface;
use MilesChou\Parkdown\Block\ParagraphBlock;
use MilesChou\Parkdown\Parser\Context;

class ParagraphChain implements ChainInterface
{
    public function handle(Context $context, callable $next): ?BlockInterface
    {
        $line = $context->current();

        if (!empty(trim($line))) {
            return new ParagraphBlock($line);
        }

        return $next($context);
    }
}
