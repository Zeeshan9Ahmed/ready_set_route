<?php


namespace App\Services\OTP;


use App\Exceptions\AppException;
use App\Models\OTPCode;
use App\Models\User;
use App\Services\BaseService;

class AccountVerification extends BaseService
{



    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'         =>  'required|email',
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
        $user = User::where('email',$data['email'])->first();
        if($user->email_verified_at){
            throw new AppException('account already verified');
        }
        if($user){
            $user->email_verified_at = now();
            $user->save();
        }
        OTPCode::where('email',$user->email)->where('ref','ACCOUNT_VERIFICATION')->delete();
        return $user;
    }

}
