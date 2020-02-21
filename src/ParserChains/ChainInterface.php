<?php

namespace MilesChou\Parkdown\ParserChains;

use MilesChou\Parkdown\Block\BlockInterface;

interface ChainInterface
{
    /**
     * @param string $line Line content
     * @param callable $next Next chain
     * @return BlockInterface|null
     */
    public function handle(string $line, callable $next): ?BlockInterface;
}
