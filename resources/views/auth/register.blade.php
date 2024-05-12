@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <div class="card">
    <div class="card-header">
        <button onclick="askForPermission()"  type="submit" class="btn btn-primary">Enable Notification</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <label for='title'>{{ __('title') }}</label>
                <input type='text' class='form-control' id='title' name='title'>
            </div>
            <div class="col-md-3">
                <label for='body'>{{ __('body') }}</label>
                <input type='text' class='form-control' id='body' name='body'>
            </div>
            <div class="col-md-3">
                <label for='idOfProduct'>{{ __('ID Of Product') }}</label>
                <input type='text' class='form-control' id='idOfProduct' name='idOfProduct'>
            </div>
            <div class="col-md-3">
                <input type="button" value="{{ 'Send Notification' }}" onclick="sendNotification()" />
            </div>
        </div>
    </div>
</div> --}}

{{-- @push('script')
    <script>
//             navigator.serviceWorker.register("{{ URL::asset('service-worker.js') }}");

// function askForPermission() {
 
//     Notification.requestPermission().then((permission) => {
//         if (permission === 'granted') {


//             // get service worker
//             navigator.serviceWorker.ready.then((sw) => {
//                 // subscribe
//                 sw.pushManager.subscribe({
//                     userVisibleOnly: true,
//                     applicationServerKey: "BGPbvN2N_ETuxiZZ90jMjXWardKtcrhDeFr93npJg5pInkDpDtJfUXRH0Het53h-zNUgRmS30N9iiCM-uN6Jsxk"
//                 }).then((subscription) => {
            
//                     console.log((subscription));
//                      saveSub(JSON.stringify(subscription));
//                 });
//             });
//         }
//     });
// }

// function saveSub(sub) {
//             $.ajax({
//                 type: 'post',
//                 url: '{{ URL('save-push-notification-sub') }}',
//                 data: {
//                     '_token': "{{ csrf_token() }}",
//                     'sub': sub
//                 },
//                 success: function(data) {
//                     console.log(data);
//                 }
//             });
//         }

        function sendNotification() {
            $.ajax({
                type: 'post',
                url: '{{ URL('send-push-notification') }}',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'title': $("#title").val(),
                    'body': $("#body").val(),
                    'idOfProduct': $("#idOfProduct").val(),
                },
                success: function(data) {
                    alert('send Successfull');
                    console.log(data);
                }
            });
        }
</script>
@endpush --}}


{{-- Public Key:
BGPbvN2N_ETuxiZZ90jMjXWardKtcrhDeFr93npJg5pInkDpDtJfUXRH0Het53h-zNUgRmS30N9iiCM-uN6Jsxk

Private Key:
0Rdr03_bupDraVkmhF6j7q73nlaPyVT-bDtMWW7NLPA --}}




@endsection
