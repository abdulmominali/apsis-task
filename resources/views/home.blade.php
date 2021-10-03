@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Here three types of notifications are shown sent separately. No Condition has been implemented yet.</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(session()->has('message'))
                        <div class="col-lg-6">
                            <div class="alert alert-{{ session('type') }}"  role="alert">
                                {{ session('message') }}
                            </div>
                        </div>
                    @endif

                    <div>
                        <ul>
                            <li>For Email: mailtrap</li>
                            <li>For SMS: nexmo</li>
                            <li>For Web Push-Notification: firebase</li>
                            <li>For BroadCast: pusher</li>
                            <li>Use Laravel Default Notification, Event, Queue</li>
                        </ul>
                    </div>

                    <div>
                        <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
                        <a href="{{ route('email') }}" class="btn btn-success btn-xs btn-flat">Send Email</a>
                        <a href="{{ route('sms') }}" class="btn btn-success btn-xs btn-flat">Send SMS</a>
                        <a href="{{ route('web-push') }}" class="btn btn-success btn-xs btn-flat">Send Web Push</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>

    var firebaseConfig = {
        apiKey: "AIzaSyCGc4zPXx9LrUu58R7Ij0_cjOgbe9aJqdw",
        authDomain: "apsis-task.firebaseapp.com",
        projectId: "apsis-task",
        storageBucket: "apsis-task.appspot.com",
        messagingSenderId: "730849968275",
        appId: "1:730849968275:web:1f98ab8c828eb435c3cd66",
        measurementId: "G-M8QFCX4L3G"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route("save-token") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token saved successfully.');
                    },
                    error: function (err) {
                        console.log('User Chat Token Error'+ err);
                    },
                });

            }).catch(function (err) {
            console.log('User Chat Token Error'+ err);
        });
    }

    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });

</script>
@endsection
