<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 28.05.2018
 * Time: 20:28
 */

namespace ModuleValidator\Rules;


use ModuleValidator\Rule;

class RegexpRuleInvert implements Rule
{
    private $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function exec(string $data): bool
    {
        return !preg_match($this->pattern,$data);
    }
}