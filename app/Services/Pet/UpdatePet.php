<?php


namespace App\Services\Pet;


use App\Models\Media;
use App\Models\Pet;
use App\Services\BaseService;
use App\Services\Common\UploadImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class UpdatePet extends BaseService
{

    public function rules()
    {
        return [
            'pet_id'        => 'required',
            'age'           => 'required|numeric|max:100',
            'gender'        => 'required|in:male,female',
            'breed'         => 'required',
            'characteristics'    => 'required|array',
            'bio'           =>'required',
            'description'   =>'required',
            'media'         =>'nullable|array',
        ];

    }

    public function execute($data){
        $this->validate($data);
        $pet = $this->updatePet($data);
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


    private function updatePet($data){
        $pet = Pet::findOrFail($data['pet_id']);
        if(isset($data['characteristics'])){
            $data['characteristics'] = json_encode($data['characteristics']);
        }
        if(isset($data['image'])){
            $data['image'] = app(UploadImage::class)->execute(['image'=>$data['image']]);
        }if(isset($data['pedigree'])){
            $data['pedigree'] = app(UploadImage::class)->execute(['image'=>$data['pedigree']]);
        }
        $pet->fill($data);
        $pet->save();
        return $pet;
    }
}
