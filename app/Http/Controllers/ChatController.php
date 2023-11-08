<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function Chat(Request $request , CommonChatController $commonChatController)
    {
        $chat_list = $commonChatController->chat_list(auth()->id(), $request->type);
        return apiSuccessMessage("Chat List", collect($chat_list));
    }

    public function user_info($id)
    {

        return User::where("id", $id)->first();
    }
}
