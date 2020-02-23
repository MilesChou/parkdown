<?php

declare(strict_types=1);

namespace MilesChou\Parkdown\Parser;

use MilesChou\Parkdown\Block\Code;
use MilesChou\Parkdown\Context;
use MilesChou\Parkdown\Contracts\Block;
use MilesChou\Parkdown\Contracts\Parser;

/**
 * @see https://daringfireball.net/projects/markdown/syntax#precode
 */
class CodeParser implements Parser
{
    public function handle(Context $context, callable $next): ?Block
    {
        $line = $context->current();

        if ($this->isCodeBlock($line)) {
            return $this->buildBlock($context);
        }

        return $next($context);
    }

    private function isCodeBlock(string $line): bool
    {
        // indent every line of the block by at least 4 spaces or 1 tab
        return strpos($line, '    ') === 0 || strpos($line, "\t") === 0;
    }

    protected function buildBlock(Context $context): Block
    {
        $block = new Code();

        while ($context->valid()) {
            $line = $context->current();

            if ($this->isCodeBlock($line)) {
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
