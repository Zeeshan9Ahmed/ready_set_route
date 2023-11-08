<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\HelpRequest;
use Illuminate\Http\Request;
use App\Models\Assist;
use Validator;
use Auth;


class AssistController extends Controller
{
    //
    public function Help(HelpRequest $request){
        
        $assist = new Assist();
        $assist->user_id = auth()->id();
        $assist->description = $request->description;
        $assist->description = $request->description;
        $assist->type = auth()->user()->role =="driver"?"driver":"user";
        $save = $assist->save();

        return apiSuccessMessage("Success", $assist);

    }
}
