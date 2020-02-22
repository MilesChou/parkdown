<?php

namespace MilesChou\Parkdown\Parser\Chain;

use MilesChou\Parkdown\Block\BlockInterface;
use MilesChou\Parkdown\Parser\Context;

class NullChain implements ChainInterface
{
    public function handle(Context $context, callable $next): ?BlockInterface
    {
        return null;
    }
}
