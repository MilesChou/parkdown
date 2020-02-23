<?php

namespace Tests;

use Illuminate\Container\Container;
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

        $this->assertSame($expected, (new Parser(new Container()))->parse($input)->render());
    }

    /**
     * @test
     */
    public function codeExample1FromDaringFireball(): void
    {
        $input = <<<Markdown
This is a normal paragraph:

    This is a code block.
Markdown;

        $expected = <<<HTML
<p>This is a normal paragraph:</p>
<pre><code>This is a code block.
</code></pre>

HTML;

        $this->assertSame($expected, (new Parser(new Container()))->parse($input)->render());
    }

    /**
     * @test
     */
    public function codeExample2FromDaringFireball(): void
    {
        $input = <<<Markdown
Here is an example of AppleScript:

    tell application "Foo"
        beep
    end tell
Markdown;

        $expected = <<<HTML
<p>Here is an example of AppleScript:</p>
<pre><code>tell application "Foo"
    beep
end tell
</code></pre>

HTML;

        $this->assertSame($expected, (new Parser(new Container()))->parse($input)->render());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenParagraphAroundCode(): void
    {
        $input = <<<Markdown
This is a normal paragraph 1.

    This is a code block.

This is a normal paragraph 2.

Markdown;

        $expected = <<<HTML
<p>This is a normal paragraph 1.</p>
<pre><code>This is a code block.
</code></pre>
<p>This is a normal paragraph 2.</p>

HTML;

        $this->assertSame($expected, (new Parser(new Container()))->parse($input)->render());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenUseTabCode(): void
    {
        $tab = "\t";
        $input = <<<Markdown
This is a normal paragraph 1.

{$tab}This is a code block.

This is a normal paragraph 2.

Markdown;

        $expected = <<<HTML
<p>This is a normal paragraph 1.</p>
<pre><code>This is a code block.
</code></pre>
<p>This is a normal paragraph 2.</p>

HTML;

        $this->assertSame($expected, (new Parser(new Container()))->parse($input)->render());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenSimpleBlockquote(): void
    {
        $input = <<<Markdown
> This is a normal paragraph.
Markdown;

        $expected = <<<HTML
<blockquote>This is a normal paragraph.
</blockquote>

HTML;

        $this->assertSame($expected, (new Parser(new Container()))->parse($input)->render());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenMoreLineSimpleBlockquote(): void
    {
        $input = <<<Markdown
> This is a normal paragraph.
>
> This is a normal paragraph.
Markdown;

        $expected = <<<HTML
<blockquote>This is a normal paragraph.

This is a normal paragraph.
</blockquote>

HTML;

        $this->assertSame($expected, (new Parser(new Container()))->parse($input)->render());
    }
}
