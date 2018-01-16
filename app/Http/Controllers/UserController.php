<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Auth;
use Hash;

class UserController extends Controller
{
    function __construct() {
        $this->middleware(function ($request, $next) {
           $user= auth()->user();

           if($user->type != 'Admin'){
                return redirect()->back();
           }
           return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('users', compact('users'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::where('id', $id)->first();
        $user->type = $request->updatedRole;
        $saved = $user->save();
        
        if($saved){
            return back()->with("success", ucwords($user->name)."'s role updated successfully!");
        }
      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function resetPassword(Request $request, $option = null)
    {
        if($option === 'password'){
            $validator = Validator::make($request->all(), [
                'userid'                => 'required',
                'password'              => 'required|min:6',
                'password_confirmation' => 'required|same:password'
            ]);

            if ($validator->fails()) {
                $check = array(
                    'success' => false, 
                    'message' => $validator->errors());
            } else {
                
                $user = User::where('id', $request->userid)->first();

                if($user) {            
                    $user->password = Hash::make($request->password);
                    $user->save();

                    $check = array(
                        'success' => true, 
                        'message' => 'Password reset successfully!');
                } else {
                    $check = array(
                        'success' => false, 
                        'message' => 'Something went wrong. Try reloading the page.');
                }         
            }

            echo json_encode($check);

        } else if($option === 'role') {
            $validator = Validator::make($request->all(), [
                'userid'                => 'required',
                'updatedRole'              => 'required'
            ]);

            if ($validator->fails()) {
                $check = array(
                    'success' => false, 
                    'message' => $validator->errors());
            } else {
                $user = User::where('id', $request->userid)->first();

                if($user) {            
                    $user->type = $request->updatedRole;
                    $user->save();

                    $check = array(
                        'success' => true, 
                        'message' => 'Role reset successfully!');
                } else {
                    $check = array(
                        'success' => false, 
                        'message' => 'Something went wrong. Try reloading the page.');
                }         
            }

            echo json_encode($check);
        }
    }

    public function userList(){
        $data = array();
        
        if(Auth::user()->type === "Admin"){
            $users = User::where('id', '!=', Auth::id())->get();

            if($users)
                foreach ($users as $key => $value) {
                    $data[$key][] = $users[$key]->id;
                    $data[$key][] = ucwords(htmlentities($users[$key]->name));
                    $data[$key][] = htmlentities($users[$key]->email);
                    $data[$key][] = $users[$key]->type;
                    $data[$key][] = $users[$key]->id;
                }
        }

        $table_data = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            'data' => $data, 
            );

        echo json_encode($table_data);
    }
}
