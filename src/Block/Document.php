<?php

declare(strict_types=1);

namespace MilesChou\Parkdown\Block;

use MilesChou\Parkdown\Contracts\Block;

class Document implements Block
{
    /**
     * @var array<Block>
     */
    private $block = [];

    public function appendBlock(Block $block): void
    {
        $this->block[] = $block;
    }

    public function render(): string
    {
        return array_reduce($this->block, static function ($c, Block $block) {
            return $c . $block->render() . PHP_EOL;
        }, '');
    }
}
