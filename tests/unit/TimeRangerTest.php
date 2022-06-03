<?php

namespace unit;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use timeranger\TimeRanger;
use timeranger\TimeRangerException;

/**
 * @covers \timeranger\TimeRanger
 */
class TimeRangerTest extends TestCase
{
    /**
     * @throws \timeranger\TimeRangerException
     */
    public function testCanCreate(): void
    {
        $this->assertInstanceOf(
            TimeRanger::class,
            new TimeRanger(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:00'),
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:01')
            )
        );
    }

    public function testCantCreateWithInvalid(): void
    {
        $this->expectException(TimeRangerException::class);

        $this->assertInstanceOf(
            TimeRanger::class,
            new TimeRanger(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:01'),
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:00')
            )
        );
    }

    public function testCanCreateYesterday(): void
    {
        $this->assertInstanceOf(
            TimeRanger::class,
            TimeRanger::createYesterday()
        );   
    }

    public function testCanReturnsTrueOnEquals(): void
    {
        $rangeA = new TimeRanger(
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:00'),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:01')
        );

        $rangeB = new TimeRanger(
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:00'),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:01')
        );

        $this->assertTrue($rangeA->equals($rangeB));
    }

    public function testCanReturnsFalseOnEquals(): void
    {
        $rangeA = new TimeRanger(
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:00'),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:01')
        );

        $rangeB = new TimeRanger(
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:00'),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:02')
        );

        $this->assertFalse($rangeA->equals($rangeB));
    }

    public function testCantCreateWithSame(): void
    {
        $this->expectException(TimeRangerException::class);

        $this->assertInstanceOf(
            TimeRanger::class,
            new TimeRanger(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:00'),
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:00')
            )
        );
    }

    /**
     * @throws \timeranger\TimeRangerException
     */
    public function testCanGetStart(): void
    {
        $range = new TimeRanger(
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:00'),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:01')
        );

        $this->assertInstanceOf(DateTimeImmutable::class, $range->getStart());
    }

    /**
     * @throws \timeranger\TimeRangerException
     */
    public function testCanGetEnd(): void
    {
        $range = new TimeRanger(
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:00'),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 00:00:01')
        );

        $this->assertInstanceOf(DateTimeImmutable::class, $range->getEnd());
    }

    /**
     * @dataProvider provideRanges
     */
    public function testCanCheckForOverlap($expected, $other): void
    {
        $rangeA = new TimeRanger(
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 14:00:00'),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 14:59:59')
        );

        $this->assertEquals($expected, $rangeA->overlap($other));
    }

    public function provideRanges(): array
    {
        return [
            [
                false,
                new TimeRanger(
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 13:00:00'),
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 13:59:59')
                ),
            ],
            [
                false,
                new TimeRanger(
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 15:00:00'),
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 15:59:59')
                ),
            ],
            [
                true,
                new TimeRanger(
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 11:00:00'),
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 14:00:03')
                ),
            ],
            [
                true,
                new TimeRanger(
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 14:59:59'),
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 15:00:03')
                ),
            ],
            [
                true,
                new TimeRanger(
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 10:59:59'),
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-01-01 16:00:03')
                ),
            ],
        ];
    }
}