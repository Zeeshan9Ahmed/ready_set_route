<?php


namespace App\Services\Pet;


use App\Models\Media;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class UploadMedia extends BaseService
{

    public function rules()
    {
        return [
            'media' => 'required',
        ];
    }

    public function execute($data){
        $this->validate($data);
        if(isset($data['media'])){
            $file  = $data['media'];
            $name = $file->store('images', [
                'disk' => config('filesystems.default'),
            ]);
            return [
                'name' => $name,
                'type' => $file->getMimeType()
            ];
        }
        return false;
    }

}
