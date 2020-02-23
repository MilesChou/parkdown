<?php

declare(strict_types=1);

namespace MilesChou\Parkdown\Contracts;

interface Block
{
    public function render(): string;
}
