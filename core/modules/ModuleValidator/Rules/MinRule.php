<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 28.05.2018
 * Time: 19:00
 */

namespace ModuleValidator\Rules;
use ModuleValidator\Rule;

class MinRule implements Rule
{
    private $len;

    public function __construct(int $len)
    {
        $this->len = $len;
    }

    public function exec(string $data): bool
    {
        return mb_strlen($data)>=$this->len;
    }
}