<?php


namespace App\Services\OTP;


use App\Exceptions\AppException;
use App\Models\OTPCode;
use App\Services\BaseService;
use Carbon\Carbon;

class ValidateOTP extends BaseService
{

    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'otp'=>'required',
            'reference_code'=>'required',
            'type'=>'required'
        ];
    }
    /**
     * Validate otp.
     *
     * @param  array  $data
     * @return OTPCode
     */
    public function execute(array $data): OTPCode
    {
        $this->validate($data);
        $check_otp = OTPCode::where(['ref'=>$data['type'],'reference_code'=>$data['reference_code']])->orderBy('id','DESC')->first();
        if($check_otp && $check_otp->code == $data['otp']) {
            $totalDuration = Carbon::parse($check_otp->created_at)->diffInHours(Carbon::now());
            if($totalDuration > 1){
                throw new AppException('otp expired');
            }
            return $check_otp;
        }
        throw new AppException('invalid otp');

    }
}
