<?php


namespace App\Services\User;


use App\Models\User;
use App\Services\BaseService;

class CreateUser extends BaseService
{



    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'          =>  'required',
            'last_name'          =>  'required',
            'email'         =>  'required|email|unique:users,email',
            'role'          =>  'required|in:user,admin',
        ];
    }
    /**
     * Create user.
     *
     * @param  array  $data
     * @return User
     */
    public function execute(array $data): User
    {
        $this->validate($data);
        $user = User::create([
            'first_name'        =>  $this->nullOrValue($data,'first_name'),
            'last_name'         =>  $this->nullOrValue($data,'last_name'),
            'email'             =>  $this->nullOrValue($data,'email'),
            'password'          =>  isset($data['password'])?bcrypt($data['password']):null,
            'role'              =>  $data['role'],
        ]);
        return $user;
    }
}
