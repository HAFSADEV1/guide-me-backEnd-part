<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Client;
use App\Models\Guid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ["error" => "Email or Password Incorrect"];
        }

        if (Client::with('user')->where('user_id', "=", $user->id)->first()) {
            return Client::with('user')->where('user_id', "=", $user->id)->firstOrFail();
        }
        return  Guid::with('user')->where('user_id', "=", $user->id)->firstOrFail();;
    }
    public function register(Request $request)
    {
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        if ($request->hasFile('avatar')) {

            $path = $request->file('avatar')->store('images');
            $user->avatar = Storage::url($path);
        }
        $user->save();
        return $user;
    }
}
