<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Guid;
use App\Models\Message;
use Illuminate\Http\Request;

class ApiMessagesController extends Controller
{
    //

    public function sendMessage(Request $request)
    {

        $message = new Message();
        $client = Client::find($request->input('client_id'));
        $guide = Guid::find($request->input('guid_id'));
        $message->msg = $request->input("msg");
        $message->client()->associate($client);
        $message->guid()->associate($guide);
        if ($message->save()) {
            return $message;
        }
        return "Error! insertion";
    }
    public function getMessages($id)
    {
        return Message::join('clients', 'clients.id', '=', 'messages.client_id')->
        join('users', 'users.id', '=', 'clients.user_id')->
        where('messages.client_id', '=', $id)->get();
    }
}
