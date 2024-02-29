<?php

namespace App\Data\Commands;

use App\Events\UserCreated;
use App\Models\User;

class CreateUser
{
    public function __invoke(CreateUserCommand $command)
    {
        $user = new User();
        $user->email = $command->getEmail();
        $user->firstName = $command->getFirstName();
        $user->lastName = $command->getLastName();
        $user->save();
        
        event(new UserCreated($user));
    }
}
