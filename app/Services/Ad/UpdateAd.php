<?php


namespace App\Services\Ad;


use App\Models\Ad;
use App\Models\Pet;
use App\Services\BaseService;

class UpdateAd extends BaseService
{


    public function rules(){
        return [
            'ad_id' => 'required',
            'pet_id' => 'required',
            'category' => 'required',
            'skills' => 'required|array',
            'characteristics' => 'required|array',
        ];
    }



    public function execute($data)
    {
        $this->validate($data);
        $ad = Ad::findOrFail($data['ad_id']);
        $pet = Pet::findOrFail($data['pet_id']);
        $data['skills'] = json_encode($data['skills']);
        $data['characteristics'] = json_encode($data['characteristics']);
        $ad->fill($data);
        $ad->save();
        return $ad;
    }
}
