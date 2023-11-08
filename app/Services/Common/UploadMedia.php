<?php


namespace App\Services\Common;


use App\Services\BaseService;

class UploadMedia extends BaseService
{

    public function rules()
    {
        return [
            'media' => 'required|mimes:jpeg,jpg,png,gif,mp4,flv|required|max:10000', // max 10000kb
            'path'  => 'required'
        ];
    }

    public function execute($data){
        $this->validate($data);
        if(isset($data['media'])){
            $file  = $data['media'];
            $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path($data['path']);
            $file->move($destinationPath, $name);
            return $name;
        }
        return false;
    }

}
