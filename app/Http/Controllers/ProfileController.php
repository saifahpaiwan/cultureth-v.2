<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use Hash;

class ProfileController extends Controller
{
    public function home()
    {     
        $data=array(); 
        return view('admin.home', compact('data'));
    }  
    
    public function profile()
    { 
        $data=array(
            "users_find" => Auth::user(),
        );   
        return view('admin.profile', compact('data'));
    }

    public function saveprofile(Request $request)
    { 
        $user=Auth::user();
        $userPassword=$user->password;  
        if($request->changepassCheck){ 
            $request->validate([
                'name' => ['required', 'string', 'max:255'], 
                'tel' => ['required'], 
                'old_password' => ['required', 'string', 'min:8'], 
                'new_password' => ['required', 'string', 'min:8', 'same:passwordConfirm'],
                'passwordConfirm' => 'required'
            ]);
            
            if (!Hash::check($request->old_password, $userPassword)) {
                return back()->withErrors(['old_password'=>'รหัสผ่านไม่ตรงกัน !']); 
            }
            
            $data=array(
                'name'      => $request->name, 
                'tel'           => $request->tel, 
                'password'  => Hash::make($request->new_password),
                
                'updated_at'  => new \DateTime(),  
                'ip_address'    => $request->ip(),
            );  
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],  
            ]);

            $data=array(
                'name'      => $request->name, 
                'tel'  => $request->tel, 

                'updated_at'  => new \DateTime(),  
                'ip_address'    => $request->ip(),
            );  
        }   
        DB::table('users')->where('users.id', $user->id)->update($data);  
        return redirect()->route('profile')->with('success', 'Update data successfully.');   
    }
}
