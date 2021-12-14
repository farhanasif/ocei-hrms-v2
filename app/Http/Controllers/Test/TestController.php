<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function meeting()
    {
        return view('admin.eventMeeting.meeting');
    }
}
