<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ApiChatController extends Controller
{
    //
    public function sendMessage(Request $request)
    {

        $chat = new Chat();
        $chat->src_user = $request->input('src_user');
        $chat->des_user = $request->input('des_user');
        $chat->msg = $request->input("msg");
        if ($chat->save()) {
            return $chat;
        }
        return "Error!!!!!";
    }
    public function getMessages($id)
    {
        return Chat::with('destination')->where('src_user', '=', $id)->get();
    }
    public function getMsgWithId($clientId, $guideID)
    {
        return Chat::where('src_user', '=', $clientId)->where('des_user', '=', $guideID)->Orwhere('src_user', '=', $guideID)->where('des_user', '=', $clientId)
            ->orderBy('created_at', 'asc')->get();
    }
    public function getGuideMessages($id)
    {
        return Chat::with('source')->where('des_user', '=', $id)->get();
    }
}
