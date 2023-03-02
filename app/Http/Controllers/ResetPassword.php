<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ResetPassword extends Controller
{
    public function search_email()
    {
        $data['title'] = 'Search Email | Reset Password';
        $data['view_page'] = 'landing.reset-password.search-email';
        return view('landing/frame' , $data);
    }

    public function send_resetPass_email(Request $request)
    {
        $userEmail = strtolower($request->user_email);
        $email_status = DB::table('users')
                        ->select('email')
                        ->where('email' , $userEmail)
                        ->first();
        if($email_status == NULL)
        {
            session()->flash('message', 'No user found with this email address. Sign Up First.');
            return redirect()->route('register');
        }
        else
        {
            $token = Str::random(8);
            $updateData = [
              'password_recovery_token' => $token  
            ];
            User::where('email' , $userEmail)->update($updateData);
            
            $data = [
                'subject'   =>"Reset Your Password",
                'email'     => $userEmail,
                'code'      => $token
                ];
              try
              {
                Mail::to($userEmail)->send(new PasswordResetMail($data));
                session()->flash('message', 'An eight digit code has been sent to your email');
                return redirect()->route('pass-reset-form' , $userEmail);
              }
              catch(Exception $e)
              {
              }
        }
    }

    public function reset_password()
    {
        $data['title'] = 'Set New Password | Reset Password';
        $data['view_page'] = 'landing.reset-password.set-password';
        return view('landing/frame' , $data);
    }

    public function set_new_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|confirmed|min:5',
        ]);
        $inputEmail = $request->input('email');
        $inputToken = $request->input('code');
        $inputPassword = $request->input('password');
        $user = User::where('email' , $inputEmail)->first();
        if($user == NULL)
        {
            session()->flash('message', 'No user found with this email address. Sign Up First.');
            return redirect()->route('register');
        }
        else
        {
            if($user->password_recovery_token != $inputToken)
            {
                session()->flash('message', 'Invalid Token!');
                return redirect()->route('pass-reset-form', $inputEmail);
            }
            else
            {
                $data = [
                    'password' => bcrypt($inputPassword),
                ];
                User::where('email' , '=' , $inputEmail)->update($data);
                session()->flash('message', 'Password reset successfully. Login now!');
                return redirect()->route('login');
            }
        }
    }
}
