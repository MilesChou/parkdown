<?php

declare(strict_types=1);

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

    /**
     * @test
     */
    public function shouldSplitEmptyMarkdownAndYaml(): void
    {
        $input = <<<INPUT
---
foo: bar
---
INPUT;

        $expectedYaml = <<<YAML
foo: bar
YAML;

        $actual = new Splitter($input);

        $this->assertSame('', $actual->getMarkdown());
        $this->assertSame($expectedYaml, $actual->getYaml());
        $this->assertTrue($actual->hasMarkdown());
        $this->assertTrue($actual->hasYaml());
    }

    /**
     * @test
     */
    public function shouldGetMarkdownOnly(): void
    {
        $input = <<<INPUT
## H2 Title
INPUT;

        $expectedMarkdown = <<<MARKDOWN
## H2 Title
MARKDOWN;

        $actual = new Splitter($input);

        $this->assertSame($expectedMarkdown, $actual->getMarkdown());
        $this->assertNull($actual->getYaml());

        $this->assertTrue($actual->hasMarkdown());
        $this->assertFalse($actual->hasYaml());
    }

    /**
     * @test
     */
    public function shouldGetMarkdownOnlyWithSomeSpace(): void
    {
        $input = <<<INPUT


## H2 Title
INPUT;

        $expectedMarkdown = <<<MARKDOWN
## H2 Title
MARKDOWN;

        $actual = new Splitter($input);

        $this->assertSame($expectedMarkdown, $actual->getMarkdown());
        $this->assertNull($actual->getYaml());

        $this->assertTrue($actual->hasMarkdown());
        $this->assertFalse($actual->hasYaml());
    }

    /**
     * @test
     */
    public function shouldGetMarkdownOnlyUseHr(): void
    {
        $input = <<<INPUT
## H2 Title

---

## H2 Title
INPUT;

        $expectedMarkdown = <<<MARKDOWN
## H2 Title

---

## H2 Title
MARKDOWN;

        $actual = new Splitter($input);

        $this->assertSame($expectedMarkdown, $actual->getMarkdown());
        $this->assertNull($actual->getYaml());

        $this->assertTrue($actual->hasMarkdown());
        $this->assertFalse($actual->hasYaml());
    }
}
