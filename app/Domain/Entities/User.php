<?php

namespace App\Domain\Entities;

class User {
    private ?int $id = null;
    private string $email;
    private string $name;


    public function __construct(string $email, string $name) {
        $this->email = $email;
        $this->name = $name;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getName(): string {
        return $this->name;
    }

}