<?php

/**
 * GlobalClock service file
 *
 * PHP Version 7.2
 *
 * @category Service
 * @package  Clock
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace App\Service;

use Innmind\TimeContinuum\Format\ISO8601;
use Innmind\TimeContinuum\Period\Earth\Year;
use Innmind\TimeContinuum\Period\Earth\Month;
use Innmind\TimeContinuum\Period\Earth\Minute;
use Innmind\TimeContinuum\Period\Earth\Millisecond;
use Innmind\TimeContinuum\TimeContinuum\Earth;
use Innmind\TimeContinuum\Timezone\Earth\America\NewYork;
use Innmind\TimeContinuum\Timezone\Earth\Europe\Paris;

/**
 * GlobalClock service class.
 *
 * @category Service
 * @package  Clock
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
final class GlobalClock
{
    /**
     * Global clock
     *
     * @var Earth
     */
    private $_clock;

    /**
     * Default clock format
     *
     * @var ISO8601
     */
    private $_format;

    /**
     * GlobalClock constructor.
     *
     * @param Earth   $clock  Get global clock
     * @param ISO8601 $format Get a format to $clock
     */
    public function __construct(Earth $clock, ISO8601 $format)
    {
        $this->_clock = $clock;
        $this->_format = $format;
    }

    /**
     * Clock getter
     *
     * @return Earth
     */
    public function getClock()
    {
        return $this->_clock;
    }

    /**
     * A "go back" example with TimeContinuum
     *
     * @return \Innmind\TimeContinuum\PointInTimeInterface
     */
    public function getGoBackSample()
    {
        return $this->_clock->now()->goBack(
            (new Year(1))
                ->add(new Month(2))
                ->add(new Minute(24))
                ->add(new Millisecond(500))
        );
    }

    /**
     * Get Paris TimeZone
     *
     * @return string
     */
    public function getNowParisSample()
    {
        return $this->_clock
            ->now()
            ->changeTimezone(new Paris())
            ->format($this->_format);
    }

    /**
     * Get New York TimeZone
     *
     * @return string
     */
    public function getNowNewYorkSample()
    {
        return $this->_clock
            ->now()
            ->changeTimezone(new NewYork())
            ->format($this->_format);
    }
}
