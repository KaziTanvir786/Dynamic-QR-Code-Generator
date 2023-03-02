<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\QRCode;
use App\Models\QRHit;
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


        $dynamicLink = url('').'/qr/' . $securityCode;
        
        $qr = QRCode::create([
            'user_id' => Session('login_id'),
            'input_text' => $request->input('user_input'),
            'dot_color' => $request->input('dot_color'),
            'eye_color' => $request->input('eye_color'),
            'dot_style' => $request->input('dot_style'),
            'eye_style' => $request->input('eye_style'),
            'random_code' => $securityCode,
            'dynamic_link' => $dynamicLink,
        ]);
        $qrid = $qr->id;

        if($request->file('logo_name'))
        {
            $upload_path = public_path('qr_icon/'.Session('login_id').'/'.$qrid);
            $fileName = $request->file('logo_name')->getClientOriginalName();
            $request->file('logo_name')->move($upload_path , $fileName);

            $icon_update = [
                'logo_name' => $fileName
            ];
            QRCode::where('id' , '=' , $qrid)->update($icon_update);
        }
        
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

    public function qr_preview($id)
    {
        $data['qr'] = QRCode::find($id);
        $data['qr_hit'] = QRHit::where('qr_id' , '=' , $id)->count();
        return view('user.qr-preview', $data);
    }

    public function qr_edit($id)
    {
        $data['qr'] = QRCode::find($id);
        return view('user.qr-edit', $data);
    }

    public function url_change(Request $request)
    {
        $data = [
            'input_text' => $request->updated_url,
        ];

        QRCode::where('id' , '=' , $request->qr_id)->update($data);
        
        session()->flash('message', 'URL Updated');
        return redirect()->route('qr_preview', $request->qr_id);
    }

    public function profile()
    {
        $data['user'] = User::where('id' , '=' , Session('login_id'))->first();
        $data['title'] = 'User Profile';
        return view("user.profile" , $data);
    }
}
