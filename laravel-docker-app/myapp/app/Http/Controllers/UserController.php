<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // Example method for creating a user
    public function createExampleUser()
    {
        $user = User::create([
            'name' => 'Taro',
            'email' => 'taro@example.com',
            'password' => Hash::make('password123'),
        ]);

        return response()->json($user);
    }
}