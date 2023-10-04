<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Newsletter;
use App\Models\Review;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $role=Auth::user()->role;
        $user=User::get();
        $data=User::get();
        $userAgent = Session::get('user_agent');
        $subscribers=Newsletter::get('email');
        $reviews=Review::get();
        $items = Item::all();

        if($role=='1'){
            return view('admin',compact('data','user','userAgent','subscribers','reviews'));
        }
        if($role=='0'){
            return view('customer',compact('items'));
        }
        else{

            return view('customer');
        }
    }

    public function Adduser()
    {
        $data = User::get();
        return view('adminfunction',compact('data'));
    }


    public function saveuser(Request $request){
         $name = $request->name;
         $email=$request->email;
         $role=$request->role;
         $password=bcrypt($request->password);
         $users=new User();
         $users->name=$name;
         $users->email=$email;
         $users->role=$role;
         $users->password=$password;
         $users->save();
         return redirect()->back();

    }
    public function edituser($id){

        $data = User::where('id','=',$id)->first();
        return view('editusers',compact('data'));
    }
    public function finishEdituser(Request $request){
        $id=$request->id;
        $name = $request->name;
        $email=$request->email;
        $role=$request->role;
        $password=$request->password;
        User::where('id','=',$id)->update([
        'name'=>$name,
        'email'=>$email,
        'role'=>$role,
        'password'=>$password
        ]);
        return redirect()->back()->with('success','user Updated successfully');
    }

public function deleteuser($id){
 User::where('id','=',$id)->delete();
 return redirect()->back()->with('success','user deleted successfully');
 }

 public function Addservice()
 {
     return view('addservice');
 }

}
