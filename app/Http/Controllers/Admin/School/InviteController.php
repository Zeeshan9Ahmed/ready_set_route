<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\School\InviteToTeacherRequest;
use App\Models\SendInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class InviteController extends Controller
{
    public function inviteForm()
    {
        return view('School.invitations.send-invite-to-teacher');
    }

    public function inviteTeacher(InviteToTeacherRequest $request)
    {
        // return auth('school')->user();
        $code = Str::random(30);

        $send_invitation = new SendInvitation( [
            'invite-to' => 'teacher',
            'email' => $request->email,
            'name' => $request->teacher_name,
            'phone_number' => $request->phone_number,
            'location' => $request->location,
            'code' => $code,
            'status' => 'pending'
        ]);
        
        // return $send_invitation;
        auth('school')->user()->sender()->save($send_invitation);
        
        $link = url('/')."/sub-admin-teacher/registration/$request->email/$code";
        // $data = [
        //     'title' => 'title',
        //     'body' => 'Subject',
        //     'link' => $link
        // ];
                // Mail::to('test@gmail.com')->send(new SendMailToSchool($data));

        return redirect()->back()->with('success', "Invitation Sent Successfully  $link");
    }
}
