<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use DB;

class ContentController extends Controller
{
    //

    
    public function content(Request $request){
        
        $type =  $request->type;
    
       $content = DB::table('contents')->where("slug","=",$type)->first();

       if(!empty($content)){
        return response()->json([
            'status' => 1,
            "message" =>"content text...!",
            'data' => $content,
             ]);
       }

       return response()->json([
        'status' => 1,
        "message" =>"content text...!",
       
         ]);

    }
}
