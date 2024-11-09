<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\LoginNeedsVerification;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function submit(Request $request)
    {
        // validate the phone number
        $request->validate([
            'phone' => 'required|numeric|min:10',
        ]);

        // find or create a user model
        $user = User::firstOrCreate([
            'phone' => $request->phone,
        ]);

        if (!$user) {
            return response()->json(['message' => 'User with the phone number not found'], 401);
        }

        // send the user a one-time use code
        $user->notify(new LoginNeedsVerification());

        // return back a response
        return response()->json([
            'message' => 'Login code sent to your phone number',
        ]);
    }

    public function verify(Request $request)
    {
        // validate the request
        $request->validate([
            'phone' => 'required|numeric|min:10',
            'login_code' => 'required|numeric|between:111111,999999',
        ]);

        // find the user with the provided phone and login code
        $user = User::where('phone', $request->phone)->where('login_code', $request->login_code)->first();

        // check if the user exists and the code is valid
        if ($user) {
            // Clear the login code after successful verification
            $user->update(['login_code' => null]);

            // Create and return the auth token
            return $user->createToken('Login Verification')->plainTextToken;
        }

        // if not, return an error message
        return response()->json(['message' => 'Invalid verification code.'], 401);
    }
}
