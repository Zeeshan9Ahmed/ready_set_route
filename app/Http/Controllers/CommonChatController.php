<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonChatController extends Controller
{
    public function chat_list(int $user_id, string $role)
    {
        $user_id = $user_id;

        // return $user_id;
        $role = $role;
        $get_chat_list_1 = DB::table('chats')
        ->select(
            'chats.*',
            'chats.reciever_id as user_id',
            DB::raw('( case 
                        when  reciever_type = "teacher" then (select teachers.name from teachers where id = chats.reciever_id ) 
                        when  reciever_type = "user" then (select users.name from users where id = chats.reciever_id ) 
                        when  reciever_type = "driver" then (select drivers.name from drivers where id = chats.reciever_id )  
                        when  reciever_type = "admin" then (select admins.name from admins where id = chats.reciever_id )  
                        when  reciever_type = "school" then (select schools.name from schools where id = chats.reciever_id )  
                        else "" 
                        end 
                    ) as name'),
                    DB::raw('( case 
                    when  reciever_type = "teacher" then (select teachers.image from teachers where id = chats.reciever_id ) 
                    when  reciever_type = "user" then (select users.image from users where id = chats.reciever_id ) 
                    when  reciever_type = "driver" then (select drivers.image from drivers where id = chats.reciever_id )  
                    when  reciever_type = "admin" then (select admins.image from admins where id = chats.reciever_id )  
                    when  reciever_type = "school" then (select schools.image from schools where id = chats.reciever_id )  
                    else "" 
                    end 
                ) as image'),
                DB::raw('( case 
                    when  reciever_type = "teacher" then "teacher" 
                    when  reciever_type = "user" then "user" 
                    when  reciever_type = "driver" then "driver"  
                    when  reciever_type = "admin" then "admin"  
                    when  reciever_type = "school" then "school"  
                    else "" 
                    end 
                ) as role')
            )
        ->where('chats.sender_type', $role)
        ->where('chats.sender_id' , $user_id);

        // return $get_chat_list_1->get();

        $get_chat_list_2 = DB::table('chats')->select(
            'chats.*',
            'chats.sender_id as user_id',
            DB::raw('( case 
                        when  sender_type = "teacher" then (select teachers.name from teachers where id = chats.sender_id ) 
                        when  sender_type = "user" then (select users.name from users where id = chats.sender_id ) 
                        when  sender_type = "driver" then (select drivers.name from drivers where id = chats.sender_id )  
                        when  sender_type = "admin" then (select admins.name from admins where id = chats.sender_id )  
                        when  sender_type = "school" then (select schools.name from schools where id = chats.sender_id )  
                        else "" 
                        end 
                    ) as name'),
                    DB::raw('( case 
                        when  sender_type = "teacher" then (select teachers.image from teachers where id = chats.sender_id ) 
                        when  sender_type = "user" then (select users.image from users where id = chats.sender_id ) 
                        when  sender_type = "driver" then (select drivers.image from drivers where id = chats.sender_id )  
                        when  sender_type = "admin" then (select admins.image from admins where id = chats.sender_id )  
                        when  sender_type = "school" then (select schools.image from schools where id = chats.sender_id )  
                        else "" 
                        end 
                    ) as image'),
                    DB::raw('( case 
                        when  sender_type = "teacher" then "teacher" 
                        when  sender_type = "user" then "user" 
                        when  sender_type = "driver" then "driver"  
                        when  sender_type = "admin" then "admin"  
                        when  sender_type = "school" then "school"  
                        else "" 
                        end 
                    ) as role'),
                    

            )
        ->Where('chats.reciever_type', $role)
        ->where('chats.reciever_id', $user_id)
        ->union($get_chat_list_1);
        
        $groupby = DB::query()->fromSub($get_chat_list_2, 'p_pn')
            ->select(
                    'id',
                    'message',
                    'user_id',
                    'image',
                    'name',
                    'role',
                    'created_at'
                )
            ->whereRaw('( id in (select Max(id) from chats where ( (sender_id = chats.sender_id and reciever_id = chats.reciever_id)  ) 
            group by user_id, role, chats.sender_id, chats.sender_type , chats.reciever_id, chats.reciever_type  )  )')
            ->orderByDesc('id')
            ->get();

            // return $groupby;
            $chats =  collect($groupby)->groupBy('user_id');
            // return $chats;
            $data = [];
            foreach ( $chats as $chat)
            {
                foreach ( collect($chat)->groupBy('role') as $t){
                    $data[] = $t[0];
                }
                // $data[] = $chat[0];
            }

            return $data;

        
    }

    public function search($keyword, $role, $user_id)
    {
        
        $users = DB::select('(SELECT id , name, "admin" as role FROM admins WHERE name LIKE "%'.$keyword.'%" ) 
                    UNION ALL
                    (SELECT id , name , "teacher" as role FROM teachers WHERE name  LIKE "%'.$keyword.'%"  ) 
                    UNION ALL
                    (SELECT id , name , "user" as role FROM users WHERE name  LIKE "%'.$keyword.'%" ) 
                    UNION ALL
                    (SELECT id , name, "school" as role FROM schools WHERE name  LIKE "%'.$keyword.'%" ) 
                    UNION ALL
                    (SELECT id , name, "driver" as role FROM drivers WHERE name  LIKE "%'.$keyword.'%" );
        ');
        $data = [];
        foreach ($users as $user)
        {
            if ( !($user->id == $user_id && $user->role == $role))
            {
                $data[] = $user;
            }
        }        
        return $data;
    }


    public function getNameAndAvatar($reciever_id, $table_name)
    {
        return collect(DB::select('SELECT 
        id, name , image from '.$table_name.'s WHERE id = "'.$reciever_id.'"'))->first();
    }
}
