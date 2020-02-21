<?php

declare(strict_types=1);

namespace MilesChou\Parkdown;

use MilesChou\Parkdown\Block\ParagraphBlock;

class Parser
{
    private $blocks = [];

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

    private function lines(string $content): iterable
    {
        $content = str_replace("\r\n", "\n", $content);

        return explode("\n", $content);
    }

    private function blockChain($line)
    {
        if (!empty(trim($line))) {
            return new ParagraphBlock($line);
        }
    }
}
