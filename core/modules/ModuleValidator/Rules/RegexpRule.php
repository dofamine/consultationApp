<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 28.05.2018
 * Time: 19:08
 */

namespace ModuleValidator\Rules;
use ModuleValidator\Rule;

class RegexpRule implements Rule
{
    private $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function exec(string $data): bool
    {
        return preg_match($this->pattern,$data);
    }
}