<?php

namespace Tests;

use Illuminate\Container\Container;
use MilesChou\Parkdown\Bridges\ParsedownMarkdownParser;
use MilesChou\Parkdown\Bridges\SymfonyYamlParser;
use MilesChou\Parkdown\Contracts\MarkdownParser;
use MilesChou\Parkdown\Contracts\YamlParser;
use MilesChou\Parkdown\Parser;
use MilesChou\Parkdown\Splitter;
use PHPUnit\Framework\TestCase;

class SplitterTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSplitMarkdownAndYaml(): void
    {
        $input = <<<INPUT
---
foo: bar
---
## H2 Title
INPUT;

        $expectedYaml = <<<YAML
foo: bar
YAML;

        $expectedMarkdown = <<<MARKDOWN
## H2 Title
MARKDOWN;

        $actual = new Splitter($input);

        $this->assertSame($expectedMarkdown, $actual->getMarkdown());
        $this->assertSame($expectedYaml, $actual->getYaml());
        $this->assertTrue($actual->hasMarkdown());
        $this->assertTrue($actual->hasYaml());
    }
}
