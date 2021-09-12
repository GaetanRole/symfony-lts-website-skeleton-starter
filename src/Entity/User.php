<?php

declare(strict_types=1);

namespace App\Entity;

use Exception;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Serializable;
use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityTimeTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="valitor.user.unique.message"
 * )
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class User implements UserInterface, Serializable
{
    use EntityIdTrait;
    use EntityTimeTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32)
     * @Assert\NotBlank(message="validator.user.firstname.not_blank")
     * @Assert\Regex(pattern="/^[a-zàâçéèêëîïôûùüÿñæœ .-]*$/i", message="validator.user.firstname.regex")
     * @Assert\Length(
     *     min=2,
     *     minMessage="validator.user.firstname.min_length",
     *     max=32,
     *     maxMessage="validator.user.firstname.max_length"
     * )
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32)
     * @Assert\NotBlank(message="validator.user.lastname.not_blank")
     * @Assert\Regex(pattern="/^[a-zàâçéèêëîïôûùüÿñæœ .-]*$/i", message="validator.user.lastname.regex")
     * @Assert\Length(
     *     min=2,
     *     minMessage="validator.user.lastname.min_length",
     *     max=32,
     *     maxMessage="validator.user.lastname.max_length"
     * )
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     * @Assert\Regex(
     *     pattern="/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/",
     *     message="validator.user.phone_number.regex")
     */
    private $phoneNumber;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *     message="validator.user.email.email"
     * )
     * @Assert\NotBlank(message="validator.user.email.not_blank")
     * @Assert\Length(
     *     max=180,
     *     maxMessage="validator.user.email.max_length"
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\Length(max=4096)
     * @Assert\Regex(pattern="/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/",
     *     message="validator.user.plain_password.regex")
     */
    private $plainPassword;

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $lastLogin;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * @throws Exception From uuid4()
     */
    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->roles[] = 'ROLE_USER';
    }

    public function __toString(): string
    {
        return $this->firstName . ' - ' . $this->lastName;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAge(): int
    {
        $now = new DateTime();

        return $now->diff($this->birthDate)->y;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTimeInterface $birthDate): self
    {
        if (null === $birthDate) {
            return $this;
        }

        $this->birthDate
            = $birthDate instanceof DateTime ? DateTimeImmutable::createFromMutable($birthDate) : $birthDate;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function hasRole(string $role): bool
    {
        if (in_array($role, $this->roles, true)) {
            return true;
        }
        return false;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getLastLogin(): ?DateTimeImmutable
    {
        return $this->lastLogin;
    }

    public function setLastLogin(DateTimeInterface $lastLogin): self
    {
        $this->lastLogin
            = $lastLogin instanceof DateTime ? DateTimeImmutable::createFromMutable($lastLogin) : $lastLogin;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function serialize(): string
    {
        return serialize([$this->id, $this->email, $this->password]);
    }

    public function unserialize($serialized): void
    {
        [$this->id, $this->email, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }
}
