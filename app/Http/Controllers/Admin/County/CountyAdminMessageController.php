<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\CommonChatController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountyAdminMessageController extends Controller
{
    public function messages(CommonChatController $chat)
    {
        $chat_list = $chat->chat_list(auth('admin')->id(), 'admin');

        // return $chat_list;
        return view('County.messages.messages-listing', compact('chat_list'));
    }

    public function chat($reciever_id , $role, CommonChatController $chat) 
    {
        $sender_id = auth('admin')->id();
        $sender_type = 'admin';
        $reciever_type = $role;
        $user = $chat->getNameAndAvatar($reciever_id, $role);
        $view = 'County.slicing.master';
        return view('Admin.messages.chat', compact('reciever_id', 'reciever_type' , 'sender_id', 'sender_type', 'user' , 'view'));
    }

    
}
