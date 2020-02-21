<?php

namespace Tests;

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
        $this->assertInstanceOf(Document::class, (new Parser())->parse());
    }
}
