<?php

namespace App\Strategies;

class StringReplaceRule
{
    protected string $pattern;
    protected string $replace;

    public function __construct($pattern, $replace)
    {
        $this->pattern = $pattern;
        $this->replace = $replace;
    }

    public function apply(string $input): string
    {
        return str_ireplace($this->pattern, $this->replace, $input);
    }
}
