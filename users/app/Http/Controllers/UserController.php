<?php

namespace App\Http\Controllers;

use App\Data\Commands\CreateUserCommand;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'firstName' => 'required|min:2',
            'lastName' => 'required|min:2',
        ]);

        $email = $data['email'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];

        $command = new CreateUserCommand($email, $firstName, $lastName);
        $this->commandBus->handle($command);

        return response()->json([
            'message' => 'success',
        ]);
    }
}
