<?php

namespace MilesChou\Parkdown\Contracts;

interface YamlParser
{
    /**
     * @param string $yaml
     * @return mixed
     */
    public function parse(string $yaml);
}
