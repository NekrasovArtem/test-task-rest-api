<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegRequest;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegRequest $request)
    {
        User::create($request->all());

        return response()->json([
            'message' => 'Registration successfuly',
        ], 200);
    }

    public function auth(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Authorization failed',
            ], 401);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'message' => 'Authorization successfuly',
            'token' => $token,
        ], 200);
    }

    public function info(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'surname' => $user->surname,
                'email' => $user->email,
                'birth_date' => $user->birth_date,
            ],
        ], 200);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $user->update($request->all());

        return response()->json([
            'message' => 'User`s information updated'
        ], 200);
    }

    public function delete(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted',
        ], 200);
    }
}
