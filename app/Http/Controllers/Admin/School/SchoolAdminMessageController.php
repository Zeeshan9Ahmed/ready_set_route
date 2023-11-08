<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\CommonChatController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolAdminMessageController extends Controller
{
    public function messages(CommonChatController $chat)
    {
        $chat_list = $chat->chat_list(auth('school')->id(), 'school');
        
        return view('School.messages.index', compact('chat_list'));

    }


    public function chat($reciever_id, $role, CommonChatController $chat)
    {
        $sender_id = auth('school')->id();
        $sender_type = 'school';
        $reciever_type = $role;
        
        $user = $chat->getNameAndAvatar($reciever_id, $role);
        $view = 'School.slicing.master';
        
        return view('Admin.messages.chat', compact('reciever_id', 'reciever_type' , 'sender_id', 'sender_type', 'user', 'view'));
    }
}
