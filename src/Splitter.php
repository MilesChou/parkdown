<?php

namespace MilesChou\Parkdown;

class Splitter
{
    /**
     * @var string
     */
    private $markdown;

    /**
     * @var string
     */
    private $yaml;

    /**
     * @param string $content
     * @param string $div
     */
    public function __construct(string $content, string $div = '---')
    {
        $div = preg_quote($div, '~');

        $regex = '~^' .
            '(' . $div . '){1}' .       // $matches[1] match `---`
            "[\r\n|\n]*" .
            '(.*?)' .                   // $matches[2] match YAML content
            "[\r\n|\n]+" .
            '(' . $div . '){1}' .       // $matches[3] match `---`
            "[\r\n|\n]*" .
            '(.*)' .                    // $matches[4] match Markdown content
            '$~s';

        if (preg_match($regex, $content, $matches) === 1) {
            $this->yaml = trim($matches[2]);
            $this->markdown = ltrim($matches[4]);
        }
    }

    /**
     * @return string
     */
    public function getMarkdown(): string
    {
        return $this->markdown;
    }

    /**
     * @return string
     */
    public function getYaml(): string
    {
        return $this->yaml;
    }

    /**
     * @return bool
     */
    public function hasMarkdown(): bool
    {
        return isset($this->markdown);
    }

    /**
     * @return bool
     */
    public function hasYaml(): bool
    {
        return isset($this->yaml);
    }
}
