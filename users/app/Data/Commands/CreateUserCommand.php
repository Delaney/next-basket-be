<?php

namespace App\Data\Commands;

class CreateUserCommand
{
    public function __construct(protected string $email, protected string $firstName, protected string $lastName)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
