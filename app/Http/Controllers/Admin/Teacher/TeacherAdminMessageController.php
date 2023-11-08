<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\CommonChatController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherAdminMessageController extends Controller
{
    public function messages(CommonChatController $chat)
    {
        $chat_list = $chat->chat_list(auth('teacher')->id(), 'teacher');
        // return $chat_list;
        return view('Teacher.messages.index', compact('chat_list'));
    }

    public function chat($reciever_id , $role, CommonChatController $chat) 
    {
        $sender_id = auth('teacher')->id();
        $sender_type = 'teacher';
        $reciever_type = $role;
        $user = $chat->getNameAndAvatar($reciever_id, $role);
        $view = 'Teacher.slicing.master';
        return view('Admin.messages.chat', compact('reciever_id', 'reciever_type' , 'sender_id', 'sender_type', 'user' , 'view'));
    }
}
