<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIController extends Controller
{


    public function messageResponse($message='success',$status=1,$data=[])
    {
        return response()->json(["status" => $status, "message" => $message, "data" => $data]);
    }

    public function successResponse($message='success',$data=[])
    {
        if((isset($data) &&  is_array($data) && count($data)>0) || (isset($data) && !is_array($data) && $data->count()) ) {
            return response()->json(["status" => 1, "message" => $message, "data" => $data]);
        }
        return response()->json(["status" => 1, "message" => $message]);
    }

    public function errorResponse($message='failed',$data=[])
    {
        if((isset($data) &&  is_array($data) && count($data)>0) || (isset($data) && !is_array($data) && $data->count()) ) {
            return response()->json(["status" => 0, "message" => $message,'data'=>$data]);
        }
        return response()->json(["status" => 0, "message" => $message]);
    }

    public function dataResponse($data=[],$message='success'){
        if((isset($data) &&  is_array($data) && count($data)>0) || (isset($data) && !is_array($data) && $data->count())){
            return response()->json(["status" => 1, "message" => $message, "data" => $data]);
        }else{
            return response()->json(["status" => 1, "message" => "No data Found","data"=>[]]);
        }
    }


    public function resourceResponse($data,$message=null)
    {
        if ((isset($data) && is_array($data) && count($data) > 0) || isset($data) && $data->count()) {
            $message = $message===null?"success":$message;
            return response()->json(["status" => 1, "message" => $message, "data" => $data]);
        }else{
            $message = $message===null?"not found":$message;
            return response()->json(["status" => 0, "message" => $message, "data" => new \stdClass()]);
        }
    }

    //
}
