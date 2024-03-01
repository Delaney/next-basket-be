<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testUserIsCreated(): void
    {
        Event::fake();

        $payload = [
            'firstName' => $this->faker->firstName,
            'lastName'  => $this->faker->lastName,
            'email'      => $this->faker->email
        ];

        $this->json('post', 'user', $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'message',
                ]
            );

        $this->assertDatabaseHas('users', $payload);
    }

    public function testPayloadValidation(): void
    {
        Event::fake();

        $this->json('post', 'user', [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(
                [
                    'message',
                    'errors' => [
                        'email',
                        'firstName',
                        'lastName',
                    ]
                ]
            );
    }

    public function testDuplicateEmail(): void
    {
        Event::fake();

        $payload = [
            'firstName' => $this->faker->firstName,
            'lastName'  => $this->faker->lastName,
            'email'      => $this->faker->email
        ];

        $user = new User();
        $user->email = $payload['email'];
        $user->firstName = $payload['firstName'];
        $user->lastName = $payload['lastName'];
        $user->save();

        $this->json('post', 'user', $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(
                [
                    'message',
                    'errors' => [
                        'email',
                    ]
                ]
            );
    }
}
