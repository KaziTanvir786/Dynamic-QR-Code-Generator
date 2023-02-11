<?php

namespace App\Http\Controllers;
use App\Models\Qr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QrDbController extends Controller
{
    public function index()
    {
        $qr = Qr::all();
        return view ('qr-code')->with('qr', $qr);
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

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        //need to check in db if exists or not
        $valueExists = DB::table('qr')
                        ->where('random_code', '=', $randomString)
                        ->exists();

        if ($valueExists) {
            for ($i = 0; $i < 1; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $securityCode = $randomString;
        } else {
            $securityCode = $randomString;
        }


        $dynamicLink = 'www.thiswebsite.com/' . $securityCode;

        $qr = Qr::create([
            'user_input' => $request->input('user_input'),
            'logo_name' => $request->input('logo_name'),
            'dot_color' => $request->input('dot_color'),
            'eye_color' => $request->input('eye_color'),
            'dot_style' => $request->input('dot_style'),
            'eye_style' => $request->input('eye_style'),
            'random_code' => $securityCode,
            'dynamic_link' => $dynamicLink,
        ]);
        $qrid = $qr->id;
        
        // echo($qrid);

        // return redirect('/qr-code')->with('flash_message', 'QR Addedd!');
        return view('/qr-code')->with('qr', $qr);  
    }

    
    public function show($qrid)
    {
        $qr = Qr::find($qrid);
        return view('/qr-code')->with('qr', $qr);
    }

    
    // public function edit($qrid)
    // {
    //     $contact = Contact::find($qrid);
    //     return view('/qr-code-edit')->with('qr', $qr);
    // }

  
    // public function update(Request $request, $qrid)
    // {
    //     $qr = Qr::find($id);
    //     $input = $request->all();
    //     $contact->update($input);
    //     $qrid = $qr->id;
        
    //     // echo($qrid);

    //     // return redirect('/qr-code')->with('flash_message', 'QR Addedd!');
    //     return view('/qr-code')->with('qr', $qr);  
    // }

   
    // public function destroy($id)
    // {
    //     Contact::destroy($id);
    //     return redirect('contact')->with('flash_message', 'Contact deleted!');  
    // }
}
