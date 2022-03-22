<?php

declare(strict_types=1);

namespace timeranger;

use DateTimeImmutable;

class TimeRanger
{
    private DateTimeImmutable $start;
    private DateTimeImmutable $end;

    /**
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @throws TimeRangerException
     */
    public function __construct(DateTimeImmutable $start, DateTimeImmutable $end)
    {
        if ($end < $start) 
        {
            throw new TimeRangerException('start is bigger than end');
        }
        
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStart(): DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEnd(): DateTimeImmutable
    {
        return $this->end;
    }
}