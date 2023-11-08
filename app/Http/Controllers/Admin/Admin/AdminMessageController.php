<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\CommonChatController;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMessageController extends Controller
{
    public function messages(CommonChatController $chat)
    {
        $chat_list = $chat->chat_list(auth('admin')->id(), 'admin');
        // return $chat_list;
        return view('Admin.messages.index', compact('chat_list'));
    }
    
    public function chat($reciever_id, $role, CommonChatController $chat)
    {
        $sender_id = auth('admin')->id();
        $sender_type = 'admin';
        $reciever_type = $role;
        
        $user = $chat->getNameAndAvatar($reciever_id, $role);
        $view = 'dashboard.master';
        return view('Admin.messages.chat', compact('reciever_id', 'reciever_type' , 'sender_id', 'sender_type', 'user', 'view'));
    }

    public function search(Request $request, CommonChatController $search)
    {
        return $search->search($request->keyword, $request->role, $request->id);
        $users = DB::table('admins')->where('name', 'LIKE', "%{$request->keyword}%")->where('id', '!=', auth('admin')->id())->get();
        return $users;
    }

    

}
