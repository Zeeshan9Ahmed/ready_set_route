<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InviteToCountyRequest;
use App\Mail\SendMailToCounty;
use App\Models\Admin as ModelsAdmin;
use App\Models\SendInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function inviteForm()
    {
        // return '$does';

        $states = DB::table('states')->select('states.id','state_name')->leftjoin('counties','states.id', 'counties.state_id')->where('admin_id', Null)->groupBy('id')->get();
        // return $states;
        return view('Admin.invitation.send-invite-to-county', compact('states'));
    }

    public function inviteCounty(InviteToCountyRequest $request)
    {

        $code = Str::random(30);

        $link = url('/')."/sub-admin-county/registration/$request->email/$code";
        $send_invitation = new SendInvitation( [
            'invite-to' => 'county',
            'email' => $request->email,
            'name' => $request->county,
            'phone_number' => $request->phone,
            'location' => $request->location,
            'code' => $code,
            'county_id' => $request->county_id,
            'invite_link' => $link,
        ]);

        $admin_id = ModelsAdmin::create([
            'email' => $request->email,
            'role' => 'county',
            'county_id' => $request->county_id
        ])->id;


        DB::table('counties')->where('id',$request->county_id)->update(['admin_id' => $admin_id]);
        auth('admin')->user()->sender()->save($send_invitation);
        
        // $data = [
        //     'title' => 'title',
        //     'body' => 'Subject',
        //     'link' => $link
        // ];
        // Mail::to('test@gmail.com')->send(new SendMailToCounty($data));
        // return redirect()->back()->with('success', 'Invitation Sent Successfully');
        return redirect()->back()->with('success', "Invitation Sent Successfully  $link");

    }
}
