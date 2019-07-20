<?php

declare(strict_types = 1);

namespace App\Tests\Service;

use \DateTime;
use \Exception;
use App\Service\GlobalClock;
use PHPUnit\Framework\TestCase;
use Innmind\TimeContinuum\Format\ISO8601;
use Innmind\TimeContinuum\TimeContinuum\Earth;

/**
 * @group   Unit
 * @group   Service
 * @see     https://github.com/Innmind/TimeContinuum
 * @author  Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class GlobalClockTest extends TestCase
{
    /** @var GlobalClock */
    private $clock;

    protected function setUp(): void
    {
        $earth = new Earth();
        $isoFormat = new ISO8601();
        $this->clock = new GlobalClock($earth, $isoFormat);
    }

    public function testGetClockMethodReturningAnEarthInstance(): void
    {
        $this->assertInstanceOf(Earth::class, $this->clock->getClock());
    }

    /**
     * @expectedException Exception DateTime Emits Exception in case of an error.
     */
    public function testGetNowInDateTimeMethodReturningACurrentDateTime(): void
    {
        $this->assertInstanceOf('Datetime', $this->clock->getNowInDateTime());
        $this->assertEquals(new DateTime('now'), $this->clock->getNowInDateTime(), '', 5);
    }
}
