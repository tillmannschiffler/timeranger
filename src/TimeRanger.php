<?php

declare(strict_types=1);

namespace timeranger;

use DateTimeImmutable;

class TimeRanger
{
    private DateTimeImmutable $foo;

    public function __construct(DateTimeImmutable $foo)
    {
        $this->foo = $foo;
    }
    
    public function getFoo(): DateTimeImmutable
    {
        return $this->foo;
    }
    
    
}