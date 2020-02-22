<?php

namespace MilesChou\Parkdown\Parser\Chain;

use MilesChou\Parkdown\Block\BlockInterface;
use MilesChou\Parkdown\Block\CodeBlock;
use MilesChou\Parkdown\Parser\Context;

/**
 * @see https://daringfireball.net/projects/markdown/syntax#precode
 */
class CodeChain implements ChainInterface
{
    public function handle(Context $context, callable $next): ?BlockInterface
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

    protected function buildBlock(Context $context): BlockInterface
    {
        $block = new CodeBlock();

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
