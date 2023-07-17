<?php

namespace App\Config;

class Demo
{
    public string $name;

    public bool $debug;

    public int $counters;

    public array $nested;

    public function __construct()
    {

        $this->name = 'home';

        $this->debug = true;

        $this->counters = 32;

        $this->nested = [
            'name' => 'ok',
            'name2' => [
                'hmmmm' => 'adasd',
                'adsd' => '123',
            ],
        ];
    }

    public static function config()
    {
        return new self;
    }

    public function nested()
    {
        return new Demo;
    }
}

class Demo_Nested_Name2
{
    public string $hmmmm;

    public string $adsd;

    public function __construct()
    {

        $this->hmmmm = 'adasd';

        $this->adsd = '123';
    }
}

class Demo_Nested
{
    public string $name;

    public array $name2;

    public function __construct()
    {

        $this->name = 'ok';

        $this->name2 = [
            'hmmmm' => 'adasd',
            'adsd' => '123',
        ];
    }

    public function name2()
    {
        return new Demo_Nested;
    }
}
