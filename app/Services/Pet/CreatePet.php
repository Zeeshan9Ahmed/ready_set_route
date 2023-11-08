<?php


namespace App\Services\Pet;


use App\Models\Media;
use App\Models\Pet;
use App\Services\BaseService;
use App\Services\Common\UploadImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class CreatePet extends BaseService
{

    public function rules()
    {
        return [
            'user_id'       => 'required',
            'name'          => 'required',
            'age'           => 'required|numeric|max:100',
            'gender'        => 'required|in:male,female',
            'breed'         => 'required',
            'characteristics'    => 'required|array',
            'image'         => 'required|mimes:jpeg,jpg,png,gif|required|max:10000', // max 10000kb
            'pedigree'      => 'required|mimes:jpeg,jpg,png,gif|required|max:10000', // max 10000kb
            'bio'           =>'required',
            'description'   =>'required',
            'media'         =>'nullable|array',
        ];

    }

    public function execute($data){
        $this->validate($data);
        $pet = $this->createPet($data);
        //UPLOAD IMAGES AND VIDEOS OF PET
        if (Arr::has($data, 'media')) {
            foreach ($data['media'] as $file){
                if($file instanceof UploadedFile){
                    $upload = app(UploadMedia::class)->execute(['media'=>$file]);
                    if($upload){
                        tap(Media::create($upload), function ($photo) use ($pet): void {
                            $pet->media()->save($photo);
                        });
                    }
                }
            }
        }
        return $pet;
    }


    private function createPet($data){
        $pet_data = [
            'user_id'           => $data['user_id'],
            'name'              => $data['name'],
            'age'               => $data['age'],
            'gender'            => $data['gender'],
            'breed'             => $data['breed'],
            'image'             => $data['image'],
            'bio'               => $data['bio'],
            'description'       => $data['description'],
            'profile_visibility' => 1,
            'characteristics'   => json_encode($data['characteristics']),
        ];
        if(isset($data['image'])){
            $pet_data['image'] = app(UploadImage::class)->execute(['image'=>$data['image']]);
        } if(isset($data['pedigree'])){
            $pet_data['pedigree'] = app(UploadImage::class)->execute(['image'=>$data['pedigree']]);
        }
        return Pet::create($pet_data);
    }
}
