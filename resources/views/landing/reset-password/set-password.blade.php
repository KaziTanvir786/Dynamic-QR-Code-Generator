<div class="full-container">
    <div class="sign-in-container-full d-flex align-items-center justify-content-center">
        <form class="sign-in-container d-flex align-items-center justify-content-center" method="post" action="{{route('set-new-password')}}">
            <div class="form-label p-4 d-flex align-items-center justify-content-center">
                <h2>Set New Password</h2>
            </div>
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            @csrf
            <div class="input-contianer d-flex align-items-center justify-content-center">
                <div class="input-group mb-3">
                    <input type="email" class="email-field form-control" name="email" value="{{request('email')}}" readonly>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="email-field form-control" name="code" placeholder="Eight digit Code">
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="email-field form-control" name="password" placeholder="Password">
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="email-field form-control" name="password_confirmation" placeholder="Confirm Password">
                </div>
                <button type="submit" class="sign-in-btn btn btn-success">Set New Password</button>
            </div>
        </form>
    </div>
</div>