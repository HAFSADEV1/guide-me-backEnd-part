<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ApiClientController extends Controller
{
    //
    public function create(Request $request)
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
        $client = new Client;
        $client->pays = $request->input('pays');
        $client->tel = $request->input('tel');
        $client->user()->associate($user)->save();
        return $client;
    }

    public function getClientById($client_id)
    {
        return Client::with('user')->where('id', '=', $client_id)->get();
    }
}
