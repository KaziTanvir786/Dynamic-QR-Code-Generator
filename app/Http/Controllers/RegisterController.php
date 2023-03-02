<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register()
    {
        $data['title'] = 'Registration Page';
        $data['view_page'] = 'landing/sign-up-page';
        return view('landing/frame' , $data);
    }

    public function register_user(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|confirmed|min:5',
        ]);

        $token = Str::random(6);
        $user_email = strtolower($request->input('email'));

        $userCheck = User::where('email' , '=' , $user_email)->first();;
        
        if($userCheck != NULL)
        {
            session()->flash('message', 'The email is already in use. Try to reset your password.');
            return redirect()->back();
        }
        $user = User::create([
            'email' => strtolower($request->input('email')),
            'phone' => strtolower($request->input('phone')),
            'password' => bcrypt($request->input('password')),
            'registered_on' => Carbon::now(),
            'email_verification_token' => $token,
        ]);
        $this->sendProfileVerifyMailTo($user_email , $token);
        session()->flash('message', 'Please check your email to activate your account');
        return redirect()->back();
    }

    public function sendProfileVerifyMailTo($email , $code)
    {
        $data = [
            'subject'   =>"Verify your Email",
            'email'     => $email,
            'code'      => $code
            ];
          try
          {
            Mail::to($email)->send(new VerificationMail($data));
          }
          catch(Exception $e)
          {
          }
    }

    public function verify_user($user_email , $token)
    {
        $checkUser = User::where('email' , '=' , $user_email)->first();
        if($checkUser!=NULL)
        {
            if($checkUser->is_active == 1)
            {
                session()->flash('message', 'Your email has activated once. Try to reset.');
                return redirect()->route('login');
            }
            else
            {
                if($checkUser->email_verification_token == $token)
                {
                    $data = [
                        'is_active' => 1,
                        'email_verified_at' => Carbon::now()->toDateTimeString(),
                    ];
                    User::where('email' , '=' , $user_email)->update($data);
                    session()->flash('message', 'Your email has been successfully activated. Please wait to get activated by the admin.');
                    return redirect()->route('login');
                }
                else
                {
                    session()->flash('message', 'Invalid Token. Try to reset your password.');
                    return redirect()->route('login');
                }
            }
        }
        else
        {
            session()->flash('message', 'User not found. Please register first.');
            return redirect()->route('login');
        }
        
    }
}
