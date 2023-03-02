<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public function test(Request $request)
    // {
    //     DB::table('site_visitor')->insert([
    //         'user_ip' => $request->ip(),
    //         'created_at' => now(),
    //     ]);
    // }

    public function test()
    {
        echo url('');
    }

    public function send_mail()
    {
        $data = [
            "subject"=>"Testing Mail",
            "code" => 'AVC34D',
            "email" => 'mahmudur.rashid26@gmail.com'
            ];
          try
          {
            Mail::to('mahmudur.rashid26@gmail.com')->send(new VerificationMail($data));
            return response()->json(['Great! Successfully send in your mail']);
          }
          catch(Exception $e)
          {
            return response()->json(['Sorry! Please try again latter']);
          }
    }
}
