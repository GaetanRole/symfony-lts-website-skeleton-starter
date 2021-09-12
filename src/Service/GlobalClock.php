<?php

declare(strict_types=1);

namespace App\Service;

use Exception;
use DateTime;
use Innmind\TimeContinuum\Earth\Clock;
use Innmind\TimeContinuum\Earth\Format\ISO8601;
use Innmind\TimeContinuum\Earth\Period\Year;
use Innmind\TimeContinuum\Earth\Period\Month;
use Innmind\TimeContinuum\Earth\Period\Minute;
use Innmind\TimeContinuum\Earth\Period\Millisecond;
use Innmind\TimeContinuum\Earth\Timezone\America\NewYork;
use Innmind\TimeContinuum\Earth\Timezone\Europe\Paris;

/**
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
class GlobalClock
{
    /**
     * Global clock
     * @var Clock
     */
    private $clock;

    /**
     * Default clock format
     * @var ISO8601
     */
    private $format;

    public function __construct(Clock $clock, ISO8601 $format)
    {
        $this->clock = $clock;
        $this->format = $format;
    }

    public function getClock(): Clock
    {
        return $this->clock;
    }

    public function getNow(): string
    {
        return $this->clock->now()->toString();
    }

    /**
     * Returning a DateTime obj based on timeZone
     * You could also use a DateTimeImmutable
     * @throws Exception Datetime Exception
     */
    public function getNowInDateTime(): DateTime
    {
        // Get a PointInTime obj with Paris TimeZone
        // And casting into a string for creating DateTime
        $now
            = $this->clock->now()->changeTimezone(new Paris())->format($this->format);
        return new DateTime($now);
    }

    /**
     * Returning a birthDate sample
     * @throws Exception Datetime Exception
     */
    public function getBirthDateSample(): DateTime
    {
        // Get a PointInTime obj with Paris TimeZone
        // And casting into a string for creating DateTime birthDate
        $now
            = $this->clock->now()->changeTimezone(new Paris());
        $birthDate
            = $now->goBack((new Year(18))
            ->add(new Month(random_int(1, 12))));
        return new DateTime($birthDate->toString());
    }

    /**
     * A "go back" example with TimeContinuum
     */
    public function getGoBackSample(): string
    {
        return $this->clock->now()->goBack(
            (new Year(1))
                ->add(new Month(2))
                ->add(new Minute(24))
                ->add(new Millisecond(500))
        )->toString();
    }

    /**
     * Get Paris TimeZone
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
     */
    public function getNowNewYorkSample(): string
    {
        return $this->clock
            ->now()
            ->changeTimezone(new NewYork())
            ->format($this->format);
    }
}
