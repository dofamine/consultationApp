<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 28.05.2018
 * Time: 18:41
 */

namespace ModuleValidator;


interface Rule
{
    public function exec(string $data):bool;
}