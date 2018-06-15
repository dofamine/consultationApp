<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 19.05.2018
 * Time: 22:16
 */

class Cache {
    private static $inst = null;
    private $memcache = null;

    private function __construct()
    {
        $this->memcache = new Memcache();
    }

    private function __sleep(){}

    private function __wakeup(){}

    public static function instance():self
    {
        return self::$inst === null ? self::$inst = new self() : self::$inst;
    }

    public function connect(?string $host = null):self
    {
        if (!$this->memcache->connect($host ? $host : '127.0.0.1', 11211))
            throw new Exception("Cannot connect to ${host} server");
        return $this;
    }

    public function add(string $key, $value):self
    {
        if (!$this->memcache->add($key,$value))
            throw new Exception("This key already exists");
        return $this;
    }

    public function get(string $key)
    {
        return $this->memcache->get($key);
    }
}