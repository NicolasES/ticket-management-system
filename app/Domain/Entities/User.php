<?php

namespace App\Domain\Entities;

class User {
    private ?int $id = null;
    private string $departmentId;
    private string $email;
    private string $name;
    private string $password;


    public function __construct(string $email, string $name, string $password, string $departmentId) {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->departmentId = $departmentId;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getDepartmentId(): string {
        return $this->departmentId;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPassword(): string {
        return $this->password;
    }
}