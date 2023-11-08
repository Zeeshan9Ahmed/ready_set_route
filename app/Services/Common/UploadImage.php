<?php


namespace App\Services\Common;


use App\Services\BaseService;

class UploadImage extends BaseService
{


    public function rules()
    {
        return [
            'image' => 'required|mimes:jpeg,jpg,png,gif|required|max:10000', // max 10000kb
        ];
    }
    public function execute($data){
        $this->validate($data);
        if(isset($data['image'])){
            $file  = $data['image'];
            $name = $file->store('images', [
                'disk' => config('filesystems.default'),
            ]);
            return $name;
        }
        return false;
    }

}
