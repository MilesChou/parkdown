<?php

declare(strict_types=1);

namespace MilesChou\Parkdown;

use MilesChou\Parkdown\Block\BlockInterface;

class Document
{
    /**
     * @var array<BlockInterface>
     */
    private $block = [];

    public function appendBlock(BlockInterface $block): void
    {
        $this->block[] = $block;
    }

    public function render(): string
    {
        return array_reduce($this->block, static function ($c, BlockInterface $block) {
            return $c . $block->render() . PHP_EOL;
        }, '');
    }
}
