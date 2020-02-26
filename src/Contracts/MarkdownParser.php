<?php

namespace MilesChou\Parkdown\Contracts;

interface MarkdownParser
{
    /**
     * @param string $markdown
     * @return string
     */
    public function parse(string $markdown): string;
}
