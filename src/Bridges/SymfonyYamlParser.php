<?php

namespace MilesChou\Parkdown\Bridges;

use MilesChou\Parkdown\Contracts\YamlParser;
use Symfony\Component\Yaml\Yaml;

class SymfonyYamlParser implements YamlParser
{
    public function parse(string $yaml)
    {
        return Yaml::parse($yaml);
    }
}
