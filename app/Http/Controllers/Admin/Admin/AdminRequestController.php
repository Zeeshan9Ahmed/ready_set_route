<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{
    public function requests()
    {
        return view('Admin.requests.index');
    }
}
