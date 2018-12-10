<?php

/**
 * GlobalClock service file
 *
 * PHP Version 7.2
 *
 * @category Clock
 * @package  App\Service
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
use Innmind\TimeContinuum\PointInTimeInterface;

/**
 * GlobalClock service class.
 *
 * @category Clock
 * @package  App\Service
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
final class GlobalClock
{
    /**
     * Global clock
     *
     * @var Earth
     */
    private $clock;

    /**
     * Default clock format
     *
     * @var ISO8601
     */
    private $format;

    /**
     * GlobalClock constructor.
     *
     * @param Earth   $clock  Get global clock
     * @param ISO8601 $format Get a format to $clock
     */
    public function __construct(Earth $clock, ISO8601 $format)
    {
        $this->clock = $clock;
        $this->format = $format;
    }

    /**
     * Clock getter
     *
     * @return Earth
     */
    public function getClock(): Earth
    {
        return $this->clock;
    }

    /**
     * Returning a DateTime obj based on timeZone
     *
     * @return \DateTime DateTime at now
     * @throws \Exception Datetime Exception
     */
    public function getNowInDateTime(): \DateTime
    {
        // Get a PointInTime obj with Paris TimeZone
        // And casting into a string for creating DateTime
        $now
            = $this->clock->now()->changeTimezone(new Paris())->format($this->format);
        return new \DateTime((string)$now);
    }

    /**
     * Returning a birthDate sample
     *
     * @return \DateTime DateTime Object
     * @throws \Exception Datetime Exception
     */
    public function getBirthDateSample(): \DateTime
    {
        // Get a PointInTime obj with Paris TimeZone
        // And casting into a string for creating DateTime birthDate
        $now
            = $this->clock->now()->changeTimezone(new Paris());
        $birthDate
            = $now->goBack((new Year(18))
            ->add(new Month(random_int(1, 12))));
        return new \DateTime((string)$birthDate);
    }

    /**
     * A "go back" example with TimeContinuum
     *
     * @return PointInTimeInterface
     */
    public function getGoBackSample(): PointInTimeInterface
    {
        return $this->clock->now()->goBack(
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
    public function getNowParisSample(): string
    {
        return $this->clock
            ->now()
            ->changeTimezone(new Paris())
            ->format($this->format);
    }

    /**
     * Get New York TimeZone
     *
     * @return string
     */
    public function getNowNewYorkSample(): string
    {
        return $this->clock
            ->now()
            ->changeTimezone(new NewYork())
            ->format($this->format);
    }
}
