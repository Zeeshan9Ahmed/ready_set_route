<?php


namespace App\Services\User;


use App\Models\User;
use App\Services\BaseService;
use App\Services\Common\UploadImage;

class UpdateUser extends BaseService
{
    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          =>  'required',
            'user_id'       =>  'required',
            'phone_no'      =>  'required',
            'bio'           =>  'required',
            'city'          =>  'required',
            'state'         =>  'required',
        ];
    }


    /**
     * Update user.
     *
     * @param  array  $data
     * @return User
     */

    public function execute($data){
        $this->validate($data,[
            'email'=>'required|email|unique:users,email,'.$data['user_id']
        ]);
        $user = User::findOrFail($data['user_id']);
        $user->update([
            'name'              =>  $this->nullOrValue($data,'name'),
            'email'             =>  $this->nullOrValue($data,'email'),
            'phone_no'          =>  $this->nullOrValue($data,'phone_no'),
            'bio'               =>  $this->nullOrValue($data,'bio'),
            'city'              =>  $this->nullOrValue($data,'city'),
            'state'             =>  $this->nullOrValue($data,'state'),
            'profile_completed' =>  1,
            'location'          =>  json_encode([
                'address'=>$this->nullOrValue($data,'location'),
                'latitude'=>$this->nullOrValue($data,'latitude'),
                'longitude'=>$this->nullOrValue($data,'longitude'),
            ]),
        ]);
        if(isset($data['image'])){
            $user->image = app(UploadImage::class)->execute(['image'=>$data['image']]);
            $user->save();
        }
        return $user;

    }
}
