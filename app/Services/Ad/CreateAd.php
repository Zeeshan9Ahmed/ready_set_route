<?php


namespace App\Services\Ad;


use App\Models\Ad;
use App\Services\BaseService;

class CreateAd extends BaseService
{


    public function rules(){
        return [
            'pet_id' => 'required',
            'user_id' => 'required',
            'category' => 'required',
            'skills' => 'required|array',
            'characteristics' => 'required|array',
        ];
    }



    public function execute($data){
        $this->validate($data);
        return Ad::create([
            'user_id'   => $data['user_id'],
            'pet_id'    => $data['pet_id'],
            'category'  => $data['category'],
            'skills'    => json_encode($data['skills']),
            'characteristics'    => json_encode($data['characteristics']),
        ]);
    }

}
