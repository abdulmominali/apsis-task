<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;

class SmsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public static function sendSMS($to = "8801880580217",$text = "Test SMS By Momin"){
        Nexmo::message()->send([
            "to" => $to,
            "from" => "sendernumber",
            "text" => $text,
        ]);

        return 1;
    }
}
