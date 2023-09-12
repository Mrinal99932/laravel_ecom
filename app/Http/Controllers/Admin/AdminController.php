<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->session()->has('ADMIN_LOGIN')){
            return redirect('admin/dashboard');
        }else{
            return view('admin.login');
        }
        return view('admin.login');
    }

    public function auth(Request $request)
    {
        $email=$request->post('email');
        $password=$request->post('password');

        // $result=Admin::where(['email'=>$email,'password'=>$password])->get();
        $result=Admin::where(['email'=>$email,'password'=>$password])->first();
        if($result){
            if(isset($result->id)){
                $request->session()->put('admin_login',true);
                $request->session()->put('log',$result->id);
                return redirect('admin/dashboard');
            }
            else{
                $request->session()->flash('error','please enter a valid email details...');
                return redirect()->to('/admin');}
        }
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

}
