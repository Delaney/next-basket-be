<?php

namespace Tests\Unit;

use App\Data\CommandBus;
use App\Data\Commands\CreateUserCommand;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserCommandTest extends TestCase
{
    public function testUserCommandCreation(): void
    {
        $payload = [
            'firstName' => $this->faker->firstName,
            'lastName'  => $this->faker->lastName,
            'email'      => $this->faker->email
        ];

        $command = new CreateUserCommand(...$payload);

        $this->assertEquals($command->getEmail(), $payload['email']);
        $this->assertEquals($command->getFirstName(), $payload['firstName']);
        $this->assertEquals($command->getLastName(), $payload['lastName']);
    }

    public function testUserCommandHandler(): void
    {
        Event::fake();

        $payload = [
            'firstName' => $this->faker->firstName,
            'lastName'  => $this->faker->lastName,
            'email'      => $this->faker->email
        ];

        $command = new CreateUserCommand(...$payload);

        $commandBus = new CommandBus();

        $commandBus->handle($command);

        $this->assertDatabaseHas('users', $payload);
    }
}
