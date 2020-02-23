<?php

declare(strict_types=1);

namespace MilesChou\Parkdown\Parser;

use MilesChou\Parkdown\Context;
use MilesChou\Parkdown\Contracts\Block;
use MilesChou\Parkdown\Contracts\Parser;

class NullParser implements Parser
{
    public function handle(Context $context, callable $next): ?Block
    {
        return null;
    }
}
