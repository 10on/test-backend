<?php declare(strict_types=1);

namespace App\Entity;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private \DateTime $created;
    private ?\DateTime $deleted;
    private ?string $notes;

    public function __construct()
    {
        $this->deleted = null;
        $this->notes = null;
    }

    public static function fromArray(array $data): self
    {
        $user = new self();
        $user->id = (int)$data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->created = new \DateTime($data['created']);
        $user->deleted = isset($data['deleted']) ? new \DateTime($data['deleted']) : null;
        $user->notes = $data['notes'] ?? null;
        return $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }

    public function getDeleted(): ?\DateTime
    {
        return $this->deleted;
    }

    public function softDelete(\DateTime $deleted): void
    {
        $this->deleted = $deleted;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }
}
