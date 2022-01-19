<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

class ResetEmail extends Controller
{
    public function send(Request $request){
        $subject = "Forgot the password??";
        $for = $_POST['email'];
        Mail::send('email',$request->all(), function($msj) use($subject,$for){
            $msj->from(env('MAIL_USERNAME'),"YouShar3");
            $msj->subject($subject);
            $msj->to($for);
        });
        return redirect()->back()
        ->with('success',trans('messages.sendMail'));
    }

    public function resetForm(){
        return "Hello";
    }
}
