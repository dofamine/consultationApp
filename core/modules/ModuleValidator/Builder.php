<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 28.05.2018
 * Time: 18:36
 */

namespace ModuleValidator;

use ModuleValidator\Rules\MaxRule;
use ModuleValidator\Rules\MinRule;
use ModuleValidator\Rules\RegexpRule;
use ModuleValidator\Rules\RegexpRuleInvert;

include_once __DIR__ . "/Rule.php";
include_once __DIR__ . "/Rules/MaxRule.php";
include_once __DIR__ . "/Rules/MinRule.php";
include_once __DIR__ . "/Rules/RegexpRule.php";
include_once __DIR__ . "/Rules/RegexpRuleInvert.php";

class Builder
{
    private $validate;

    public function __construct()
    {
        $this->validate = new \ModuleValidate();
    }

    public function build(): \ModuleValidate
    {
        return $this->validate;
    }

    public function max(int $value): self
    {
        $this->validate->addRule(new MaxRule($value));
        return $this;
    }

    public function min(int $value): self
    {
        $this->validate->addRule(new MinRule($value));
        return $this;
    }

    public function len(int $min, int $max): self
    {
        return $this->min($min)->max($max);
    }

    public function regexp(string $regexp): self
    {
        $this->validate->addRule(new RegexpRule($regexp));
        return $this;
    }
    public function regexpInvert(string $regexp): self
    {
        $this->validate->addRule(new RegexpRuleInvert($regexp));
        return $this;
    }

    public function containsNumber(): self
    {
        return $this->regexp('/\d+/');
    }

    public function onlyNumbers(): self
    {
        return $this->regexp('/^\d+$/');
    }

    public function containsUpper(): self
    {
        return $this->regexp('/[A-Z]/');
    }

    public function containsLower(): self
    {
        return $this->regexp('/[a-z]/');
    }

    public function password(): self
    {
        return $this->containsLower()->containsNumber()->containsUpper();
    }

    public function withoutSpaces()
    {
        return $this->regexpInvert("/\s/");
    }
}
