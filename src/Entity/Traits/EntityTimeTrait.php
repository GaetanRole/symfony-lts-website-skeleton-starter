<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * This entity trait is useful to keep dates information or useful for:
 *
 * @see     https://packagist.org/packages/gedmo/doctrine-extensions.
 * @see     https://github.com/Atlantic18/DoctrineExtensions/blob/master/doc/timestampable.md
 *
 * You can also use MappedSuperclass but not recommended.
 * @see     https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/inheritance-mapping.html
 * @see     https://medium.com/@galopintitouan/using-traits-to-compose-your-doctrine-entities-9b516335119b
 *
 * @author  Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
trait EntityTimeTrait
{
    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @var DateTimeInterface|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /* Auto generated methods */

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt
            = $createdAt instanceof DateTime ? DateTimeImmutable::createFromMutable($createdAt) : $createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
