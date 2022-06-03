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
        $this->ensureRangeIsValid($start, $end);

        $this->start = $start;
        $this->end = $end;
    }

    /**
     * checks if range overlaps
     *
     * @param TimeRanger $other
     * @return bool
     */
    public function overlap(self $other): bool
    {
        if (($other->getStart() <= $this->getEnd()) and ($other->getEnd() >= $this->getStart())) {
            return true;
        }

        return false;
    }

    /**
     * checks if range is equal
     *
     * @param TimeRanger $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        if (($this->getStart() == $other->getStart()) and ($this->getEnd() == $other->getEnd())) {
            return true;
        }

        return false;
    }

    /**
     * @throws TimeRangerException
     */
    public static function createYesterday(): self
    {
        return new self(
            new DateTimeImmutable('yesterday 0:0:0'),
            new DateTimeImmutable('yesterday 23:59:59')
        );
    }

    /**
     * Guard this
     *
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return void
     * @throws TimeRangerException
     */
    private function ensureRangeIsValid(DateTimeImmutable $start, DateTimeImmutable $end): void
    {
        if ($end > $start) {
            return;
        }

        throw new TimeRangerException('start is bigger than end');
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