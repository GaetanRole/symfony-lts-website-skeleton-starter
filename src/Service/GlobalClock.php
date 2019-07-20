<?php

declare(strict_types=1);

namespace App\Service;

use Exception;
use DateTime;
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
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
class GlobalClock
{
    /**
     * Global clock
     * @var Earth
     */
    private $clock;

    /**
     * Default clock format
     * @var ISO8601
     */
    private $format;

    public function __construct(Earth $clock, ISO8601 $format)
    {
        $this->clock = $clock;
        $this->format = $format;
    }

    public function getClock(): Earth
    {
        return $this->clock;
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
        return new DateTime((string)$birthDate);
    }

    /**
     * A "go back" example with TimeContinuum
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
