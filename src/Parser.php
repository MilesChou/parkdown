<?php

declare(strict_types=1);

namespace MilesChou\Parkdown;

use MilesChou\Parkdown\Block\BlockInterface;
use MilesChou\Parkdown\Block\ParagraphBlock;

class Parser
{
    public function parse(string $content): Document
    {
        $doc = new Document();

        $lines = $this->lines($content);

        foreach ($lines as $line) {
            if ($block = $this->blockChain($line)) {
                $doc->appendBlock($block);
            }
        }

        return $doc;
    }

    /**
     * @param string $content
     * @return iterable<string>
     */
    private function lines(string $content): iterable
    {
        $content = str_replace("\r\n", "\n", $content);

        return explode("\n", $content);
    }

    /**
     * @param string $line
     * @return BlockInterface|null
     */
    private function blockChain(string $line): ?BlockInterface
    {
        if (!empty(trim($line))) {
            return new ParagraphBlock($line);
        }

        return null;
    }
}
