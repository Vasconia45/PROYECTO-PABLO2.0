<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserRegisterController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = DB::table('users')
            ->where('user_name', $request->user_name)
            ->orwhere('email', $request->email)
            ->get();
        if (count($users) <= 0) {
            $this->confirmation($request);
            return redirect()->route('landingPage')
                ->with('success', trans('messages.sendMail'));
        } else {
            return redirect()->route('landingPage')
                ->with('error', trans('messages.error'));
        }
    }
    
    public function confirmation(Request $request)
    {
        $subject = "Registration";
        $for = $_POST['email'];
        Mail::send('/emails/confirmationMail', $request->all(), function ($msj) use ($subject, $for) {
            $msj->from(env('MAIL_USERNAME'), "YouShar3");
            $msj->subject($subject);
            $msj->to($for);
        });

        return view('/emails/confirmationMail', ['request' => $request->all()]);
    }
    public function registro(Request $request)
    {
        $request->validate([
            'user_name' => 'required|max:20|unique:users',
            'email' => 'required|email|unique:users',  
            'password' => 'required|min:8|max:16|regex:/[^a-zA-Z0-9]/',
            'birth_date' => 'required',
        ]);
        User::create([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birth_date,
            'user_type' => 'user',
        ]);

        return redirect()->route('landingPage')
        ->with('confirmation', trans('messages.registerMessage'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
