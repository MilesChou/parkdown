<?php

namespace Tests;

use Illuminate\Container\Container;
use MilesChou\Parkdown\Document;
use MilesChou\Parkdown\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnDocumentWhenCallParse(): void
    {
        $input = <<<Markdown
This is a regular paragraph.

This is another regular paragraph.
Markdown;

        $expected = <<<HTML
<p>This is a regular paragraph.</p>
<p>This is another regular paragraph.</p>

HTML;

        $this->assertSame($expected, (new Parser(new Container()))->parse($input)->html());
    }
}
