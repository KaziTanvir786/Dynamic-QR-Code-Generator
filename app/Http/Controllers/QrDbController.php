<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\QRCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;

class QrDbController extends Controller
{
    public function index()
    {
        $qr = QRCode::all();
        return view ('qr-code')->with('qr', $qr);
    }

    public function generator()
    {
        return view('user.dynamic-qr-code-generator');
    }
    
    public function create()
    {
        return view('dynamic-qr-code-generator.blade');
    }
   
    public function store_qr(Request $request)
    {
        $request->validate([
            'user_input' => 'required',
        ]);

        $securityCode = Str::random(6);


        $dynamicLink = 'www.thiswebsite.com/' . $securityCode;
        
        $qr = QRCode::create([
            'user_id' => Session('login_id'),
            'input_text' => $request->input('user_input'),
            'logo_name' => $request->input('logo_name'),
            'dot_color' => $request->input('dot_color'),
            'eye_color' => $request->input('eye_color'),
            'dot_style' => $request->input('dot_style'),
            'eye_style' => $request->input('eye_style'),
            'random_code' => $securityCode,
            'dynamic_link' => $dynamicLink,
        ]);
        $qrid = $qr->id;
        
        session()->flash('message', 'QR Code Generated');
        return redirect()->route('qr_generated' , $qrid);  
    }

    public function qr_generated($id)
    {
        $data['qr'] = QRCode::find($id);
        return view('user.qr-code', $data);
    }

    public function qr_list()
    {
        $data['qrs'] = QRCode::where('user_id' , '=' , Session('login_id'))->orderBy('id', 'DESC')->get();
        return view('user.qr-list', $data);
    }

    public function profile()
    {
        $data['user'] = User::where('id' , '=' , Session('login_id'))->first();
        $data['title'] = 'User Profile';
        return view("user.profile" , $data);
    }
}
