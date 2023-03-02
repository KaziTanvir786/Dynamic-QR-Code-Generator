<div class="full-container">
    <div class="sign-in-container-full d-flex align-items-center justify-content-center">
        <form class="sign-in-container d-flex align-items-center justify-content-center" method="post" action="{{route('login-user')}}">
            <div class="form-label p-4 d-flex align-items-center justify-content-center">
                <h2>Sign in</h2>
            </div>
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            @csrf
            <div class="input-contianer d-flex align-items-center justify-content-center">
                <div class="input-group mb-3">
                    <input id="input-email" oninput="validateEmail()" type="email" name="login_email" placeholder="Email" class="email-field form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
                <div class="input-group mb-3">
                    <input id="input-pass" oninput="validatePass()" type="password" name="login_password" placeholder="Password" class="pass-field form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
                <button type="submit" class="sign-in-btn btn btn-success">Sign in</button>
                <hr>
                <div class="bottom-links d-flex align-items-center justify-content-center">
                    <p class="p-1 m-0">Forget password? <a href="{{route('reset-password')}}">Reset</a></p>
                    <p class="p-1 m-0">Not registered yet? <a href="{{route('register')}}">Sign up</a></p>
                </div>
            </div>
        </form>
    </div>
</div>