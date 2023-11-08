<?php
namespace App\Traits;
use App\Exceptions\AppException;
use App\Models\Appointment;
use App\Models\Schedule;

trait TimeSlot{




    public function doctor_time_slots($doctor_id, $date ){
        $date=strtotime($date);
        $day = date('l', $date);
        $doctor_schedules = Schedule::where('doctor_id',$doctor_id)->where('day',$day)->where('status',1)->first();
        if(!$doctor_schedules){
            throw new AppException('doctor has no any slot available for '.$date);
        }
        $doctor_slots = $generate_time_slots($doctor_schedules->from_time , $doctor_schedules->to_time);
        $appointments  = Appointment::whereIn('start_time',$doctor_slots)
            ->whereDate('appointment_date',$date)
            ->where('doctor_id',$doctor_id)
            ->get()->pluck('start_time')->toArray();
        $times = [];

        foreach ($doctor_slots as $slot){
            $times[] = [
                'time' => $slot,
                'status' => in_array($slot , $appointments)?"Booked":"Available"
            ];
        }
        $doctor_time_slots = $times;
        return $times;
    }





}
