<?php


namespace App\Services\OTP;


use App\Mail\AccountVerificationOTPMail;
use App\Models\OTPCode;
use App\Models\User;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class GenerateOTP extends BaseService
{


    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'         =>  'required',
        ];
    }
    /**
     * Create user.
     *
     * @param  array  $data
     * @return OTPCode
     */
    public function execute(array $data): OTPCode
    {
        $this->validate($data);
        return OTPCode::create([
            'user_id' => $this->nullOrValue($data,'user_id'),
            'email' => $this->nullOrValue($data,'email'),
            'ref' => $data['type'],
//            'code' => rand(100001,999999),
            'code' => 123456,
            'reference_code' => rand(100001,999999),
            'expiring_at' => Carbon::now()->addMinutes(60),
        ]);
    }
}
