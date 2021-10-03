<?php

use App\Events\TaskEvent;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NPreferController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Notifications\CommonMail;
use App\Notifications\Common;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendEmailJob;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// testing
/*
Route::get('/sendEmail',function(){
    SendEmailJob::dispatch()->delay(Carbon::now()->addSeconds(5));
    return "Email is Send Properly.";
} );
Route::get('/event',function(){
    event(new TaskEvent('Hey how are you'));
} );
Route::get('test', function () {
    event(new App\Events\TaskEvent('Someone'));
    return "Event has been sent!";
});
Route::get('task', function () {
    $user = User::find(1)->notify(new Common);
    return "Task Notification Test ....";
});*/
Route::get('', [HomeController::class, 'index'])->name('home');


Auth::routes();

Route::get('/markAsRead', function () {
    auth()->user()->unreadNotifications->markAsRead();

    session()->flash('type','success');
    session()->flash('message','All notifications have been read.');
    return redirect()->back();
})->name('markRead');
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::post('/save-token', [HomeController::class, 'saveToken'])->name('save-token');
Route::group(['prefix'=>'notify'],function(){
    Route::get('', [HomeController::class, 'index'])->name('home');

    Route::get('/email', function () {
        $user = User::find(auth()->id());
        //event(new TaskEvent('Hey how are you'));

        User::find(auth()->id())->notify(new Common);
        Notification::send($user, new CommonMail());

        session()->flash('type','success');
        session()->flash('message','Mail send successfully.');
        return redirect()->back();
    })->name('email');

    Route::get('/web-push', function () {
        if(!empty(auth()->user()->device_token)){
            $request = ["title" => "Notification Title","body" => "Notification Body"];
            $check = HomeController::sendNotification([auth()->user()->device_token], $request);
        }else{
            session()->flash('type','errors');
            session()->flash('message','You first need to click Allow for Notification button.');
            return redirect()->back();
        }
        User::find(auth()->id())->notify(new Common);

        session()->flash('type','success');
        session()->flash('message','Web push send successfully.');
        return redirect()->back();
    })->name('web-push');

    Route::get('/sms', function () {
        $to = "8801880580217";
        $sms = "Test message";
        //SmsController::sendSMS($to, $sms);

        User::find(auth()->id())->notify(new Common);

        session()->flash('type','success');
        session()->flash('message','SMS send successfully.');
        return redirect()->back();
    })->name('sms');
});

//Route::resource('/users', UserController::class);
//Route::resource('/employees', EmployeeController::class);
//Route::resource('/nprefer', NPreferController::class);
