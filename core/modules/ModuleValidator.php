<?php

use ModuleValidator\Builder;

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 28.05.2018
 * Time: 19:25
 */
class ModuleValidator
{
    private $data = [];
    private $rules = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function addRule(string $key, string $errorMessage, Builder $builder)
    {
        $this->rules[$key] = [$builder->build(), $errorMessage];
    }

    public function execValidation(array &$errors):bool
    {
        $result = true;
        foreach ($this->rules as $key => $rule) {
            if (!$rule[0]->validate($this->data[$key])) {
                $errors[$key] = $rule[1];
                $result = false;
            }
        }
        return $result;
    }

    public static function trimArray(array &$data)
    {
        foreach ($data as &$item) {
            $item = trim($item);
        }
    }

    public static function isSomeEmpty(array $data): bool
    {
        foreach ($data as $item) {
            if (empty($item)) return true;
        }
        return false;
    }

}