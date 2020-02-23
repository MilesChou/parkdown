<?php

declare(strict_types=1);

namespace MilesChou\Parkdown\Parser;

use MilesChou\Parkdown\Block\Paragraph;
use MilesChou\Parkdown\Context;
use MilesChou\Parkdown\Contracts\Block;
use MilesChou\Parkdown\Contracts\Parser;

class ParagraphParser implements Parser
{
    public function handle(Context $context, callable $next): ?Block
    {
        $line = $context->current();

        if (!empty(trim($line))) {
            return new Paragraph($line);
        }

        return $next($context);
    }
}
