<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $result['home_categories']=DB::table('categories')
                ->where(['status'=>1])
                ->where(['is_home'=>1])
                ->get();


        foreach($result['home_categories'] as $list){
            $result['home_categories_product'][$list->id]=
                DB::table('products')
                ->where(['status'=>1])
                ->where(['category_id'=>$list->id])
                ->get();

            foreach($result['home_categories_product'][$list->id] as $list1){
                $result['home_product_attr'][$list1->id]=
                    DB::table('products_attr')
                    ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                    ->leftJoin('colors','colors.id','=','products_attr.color_id')
                    ->where(['products_attr.products_id'=>$list1->id])
                    ->get();
                
            }
        }
         
        return view('front.index',$result);
    }
    public function product(Request $request,$slug)
    {
        
            $result['product']=
            DB::table('products')
            ->where(['status'=>1])
            ->where(['slug'=>$slug])
            ->get();

        foreach($result['product'] as $list1){
            $result['product_attr'][$list1->id]=
                DB::table('products_attr')
                ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                ->leftJoin('colors','colors.id','=','products_attr.color_id')
                ->where(['products_attr.products_id'=>$list1->id])
                ->get();
        }
        $result['related_product']=
            DB::table('products')
            ->where(['status'=>1])
            ->where('slug','!=',$slug)
            ->where(['category_id'=>$result['product'][0]->category_id])
            ->get();
        foreach($result['related_product'] as $list1){
            $result['related_product_attr'][$list1->id]=
                DB::table('products_attr')
                ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                ->leftJoin('colors','colors.id','=','products_attr.color_id')
                ->where(['products_attr.products_id'=>$list1->id])
                ->get();
        }
        return view('front.product',$result);
        
        
    }
    public function add_to_cart(Request $request,User $user)
    {
        if($request->session()->has('logged_in'))
        {
            $model=new Cart;
            $model->product_id=$request->product_id;
            $model->user_id=$request->session()->get('user_id');
            $model->price=$request->price;
            $model->save();
            return redirect('/');
        }
        else{
            echo"Wrong";
        }
            
        
        
    }
    public function cart(Request $request)
    {
        $item=Cart::all();
        return view('front.cart',['item'=>$item]); 
    }
    public function cartdelete(Request $req,$id)
    {
        $model=Cart::find($id);
        $model->delete($id);
        return redirect('cart');
    }
    public function checkout()
    {
        return view('front.checkout');
    }
    public function dologin(Request $request)
    {
        $email=$request->input('email');
        $password=$request->input('password');
        $user=User::where(['email'=>$email,'password'=>$password])->first();
        
            if ($user){
                $request->session()->put('logged_in',true);
                $request->session()->put('user_id',$user->id);
                $request->session()->put('user_name',$user->name);
                return redirect('/');
                
             }
             else{
               return redirect('/');
             }
            

    }
    public function registration(Request $request)
    {
        if($request->session()->has('logged_in')!=null){
            return redirect('/');
        }
        return view('front.registration');
    }
    public function adduser(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:user',
            'phone'=>'required|numeric|min:10|max:10',
        ]);
        User::create($request->all());
        return redirect('/');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/');
    }
    

}
