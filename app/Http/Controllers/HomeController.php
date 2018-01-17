<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Auth;
use Hash;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    public function profile(){
        $users = User::where('id', Auth::id())->get();
        return view('profile', compact('users'));
    }

     public function changePassword(Request $request,$option = null){          
          if($option === 'password'){
           
            $validator = Validator::make($request->all(), [
                'OpasswordCheck'         => 'required',
                'Opassword'              => 'required',
                'userid'                 => 'required',
                'Npassword'              => 'required|min:6',
                'Npassword_confirmation' => 'required|same:Npassword'
            ]);

             
             
            if ($validator->fails()) {
                $check = array(
                    'success' => false, 
                    'message' => 'New Password Does not Match!');
            } else if(Hash::check($request->Opassword, $request->OpasswordCheck)) {
                
                $user = User::where('id', $request->userid)->first();

                if($user) {            
                    $user->password = Hash::make($request->Npassword);
                    $user->save();

                    $check = array(
                        'success' => true, 
                        'message' => 'Password reset successfully!');
                } else {
                    $check = array(
                        'success' => false, 
                        'message' => 'Something went wrong. Try reloading the page.');
                }         
            }else{
                  $check = array(
                        'success' => false, 
                        'message' => 'Incorrect Current Password!');
            }

            echo json_encode($check);
}
 
    }
   
}
