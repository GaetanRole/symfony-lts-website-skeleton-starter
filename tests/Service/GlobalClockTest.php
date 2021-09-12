<?php

declare(strict_types=1);

namespace App\Tests\Service;

use \DateTime;
use App\Service\GlobalClock;
use Innmind\TimeContinuum\Earth\Format\ISO8601;
use Innmind\TimeContinuum\Earth\Clock;
use PHPUnit\Framework\TestCase;

/**
 * @group   Unit
 * @group   Service
 *
 * @see     https://github.com/Innmind/TimeContinuum
 * @author  Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class GlobalClockTest extends TestCase
{
    /** @var GlobalClock */
    private $clock;

    protected function setUp(): void
    {
        $clock = new Clock();
        $isoFormat = new ISO8601();
        $this->clock = new GlobalClock($clock, $isoFormat);
    }

    public function testGetClockMethodReturningAnEarthInstance(): void
    {
        $this->assertInstanceOf(Clock::class, $this->clock->getClock());
    }

    public function testGetNowInDateTimeMethodReturningACurrentDateTime(): void
    {
        $this->assertInstanceOf('Datetime', $this->clock->getNowInDateTime());
        $this->assertEqualsWithDelta(new DateTime('now'), $this->clock->getNowInDateTime(), 5, '');
    }
}
