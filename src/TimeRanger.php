<?php

declare(strict_types=1);

namespace timeranger;

class TimeRanger
{
    private string $foo;

    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }

    /**
     * @return string
     */
    public function getFoo(): string
    {
        return $this->foo;
    }
    
    
}