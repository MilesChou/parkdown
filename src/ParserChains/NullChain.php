<?php

namespace MilesChou\Parkdown\ParserChains;

use MilesChou\Parkdown\Block\BlockInterface;

class NullChain implements ChainInterface
{
    public function handle(string $line, callable $next): ?BlockInterface
    {
        return null;
    }
}
