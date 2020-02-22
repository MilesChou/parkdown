<?php

namespace MilesChou\Parkdown\Parser\Chain;

use MilesChou\Parkdown\Block\BlockInterface;
use MilesChou\Parkdown\Parser\Context;

interface ChainInterface
{
    /**
     * @param Context<string> $context
     * @param callable $next Next chain
     * @return BlockInterface|null
     */
    public function handle(Context $context, callable $next): ?BlockInterface;
}
