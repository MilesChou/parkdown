<?php

declare(strict_types=1);

namespace MilesChou\Parkdown\Contracts;

use MilesChou\Parkdown\Context;

interface Parser
{
    /**
     * @param Context<string> $context
     * @param callable $next Next chain
     * @return Block|null
     */
    public function handle(Context $context, callable $next): ?Block;
}
