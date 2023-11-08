<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use App\Http\Requests\County\InviteToSchoolRequest;
use App\Mail\SendMailToSchool;
use App\Models\SendInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class InviteController extends Controller
{
    public function inviteForm()
    {
        return view('County.invitations.send-invite-to-school');
    }

    public function inviteSchool(InviteToSchoolRequest $request)
    {

        $code = Str::random(30);

        $send_invitation = new SendInvitation( [
            'invite-to' => 'school',
            'email' => $request->email,
            'name' => $request->name,
            'phone_number' => $request->phone,
            'location' => $request->location,
            'code' => $code,
            'status' => 'pending'
        ]);
        
        // return $send_invitation;
        auth('admin')->user()->sender()->save($send_invitation);
        
        $link = url('/')."/sub-admin-school/registration/$request->email/$code";
        // $data = [
        //     'title' => 'title',
        //     'body' => 'Subject',
        //     'link' => $link
        // ];
                // Mail::to('test@gmail.com')->send(new SendMailToSchool($data));

        return redirect()->back()->with('success', "Invitation Sent Successfully  $link");

        
    }
}
