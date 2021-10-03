<?php

namespace App\Http\Controllers\Notify;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DemoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate()
    {
        $users = User::all();
        return  view('user.index', compact('users'));
    }
}
