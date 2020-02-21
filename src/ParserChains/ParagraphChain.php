<?php

namespace MilesChou\Parkdown\ParserChains;

use MilesChou\Parkdown\Block\BlockInterface;
use MilesChou\Parkdown\Block\ParagraphBlock;

class ParagraphChain implements ChainInterface
{
    public function handle(string $line, callable $next): ?BlockInterface
    {
        if (!empty(trim($line))) {
            return new ParagraphBlock($line);
        }

        return $next($line);
    }
}
