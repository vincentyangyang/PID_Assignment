<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Good;
use App\Order;
use App\Orderitem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class userController extends Controller
{
 
    public function login(Request $request){
        if($request->input('logout')){
            $request->session()->forget('login');
            $request->session()->forget('id');
            return redirect()->route('login');
        }

        if(session('login')){
            return redirect()->route('goodsList');
        }

        return view('login');
    }


    public function loginPost(Request $request){
        $admin = $request->input('admin');
        $customer = Customer::where('admin',$admin)->first();

        if($customer){
            $re = password_verify($request->input('pass'),$customer['password']);

            if($re){
                if($customer['authority'] == 0){
                    return 'cantLogin';
                }else{
                    session(["login"=>$admin, "id"=>$customer['cId']]);
                    return 'success';  
                }

            }else{
                return 'fail';
            }
        }else{
            return 'fail';
        }
    }


    public function register(){
        return view('register');
    }

    public function registerPost(Request $request){

        $admin = $request->input('admin');

        $customer = Customer::where('admin',$admin)->first();

        if($customer){
            return "exist";
        }else{
            $pass = password_hash($request->input('pass'),PASSWORD_DEFAULT);

            $att['admin'] = $request->input('admin');
            $att['password'] = $pass;
            $att['email'] = $request->input('email');
            $att['birthday'] = $request->input('birthday');
            $att['phone'] = $request->input('phone');

            // Customer::create($att);

            // $c = new Customer;

            // $c->admin = $request->input('admin');
            // $c->password = $pass;
            // $c->email = $request->input('email');
            // $c->birthday = $request->input('birthday');
            // $c->phone = $request->input('phone');
            // $c->save();

            DB::insert('insert into customers (admin,password,email,birthday,phone) values (?,?,?,?,?)', 
                [$att['admin'],$att['password'],$att['email'],$att['birthday'],$att['phone']]);
        }
    }
    public function goodsList(){
            $goods = Good::all();
            $data = ['goods'=>$goods];
            return view('goodsList',$data);
    }

    public function goodsDetail(Request $request){
        $id = $request->input('id');
        $good = Good::where('gId',$id)->first();
        $data = ['good'=>$good];

        return view('goodsDetail',$data);
    }
    public function addPost(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $image = $request->input('image');
        $price = $request->input('price');
        $quantity = $request->input('quantity');
        $page = $request->input('page');


        //SESSION中沒有cart
        if (empty(session('carts'))){
            $request->session()->put('carts', []);
        }

        $count = count(session('carts'));

        //刪除/更改商品數量
        if ($page == 'cart'){
            $carts = session('carts');
            $i = 0;

            foreach($carts as $cart){
                if ($cart[0] == $id){
                    if($quantity == 0){
                        unset($carts[$i]);
                        $carts = array_values($carts);
                        $request->session()->put('carts', $carts);
                        return session('carts');
                    }else{
                        $cart[4] = $quantity;
                        $carts[$i] = $cart;
                        $request->session()->put('carts', $carts);
                        return session('carts');                   
                    }
                break;
                }
                $i += 1;
            }
            return 'success';
        }

        $flag = 0;

        // SESSION中的格式[id,名稱,照片,價格,數量]
   
        //若cart中有該商品則數量+1
        $carts = session('carts');
        $i = 0;
        foreach($carts as $cart){
            if ($cart[0] == $id){
                $cart[4] += 1;
                $carts[$i] = $cart;
                $request->session()->put('carts', $carts);
                $flag = 1;
                break;
            }
            $i += 1;
        }
        
        //若購物車沒有此商品新增一筆SESSION
        if ($flag == 0){
            $item = [$id, $name, $image, $price, 1];
            $request->session()->push('carts', $item);
        }

        return session('carts');

    }


    public function cart(){
            $carts = session('carts');

            if (!empty($carts)){
                $total = 0;
                $arrayList = array();
        
                foreach($carts as $cart){
                    $sum = $cart[3] * $cart[4];  //每樣商品總計
                    $total += $sum;  //購物車總價
        
                    array_push($cart,$sum);
                    array_push($arrayList,$cart);
                }
                $data = ['carts'=>$arrayList, 'total'=>$total];
        
                return view('cart', $data);
            }else{
                $data = ['carts'=>[], 'total'=>''];
                return view('cart', $data);
            }        

    }


    public function cartPost(Request $request){
        $carts = session('carts');
        $total = $request->input('total');

        DB::insert('insert into orders(cId, total) values (?,?)', 
            [session('id'), $total]);

        $firstOrder = Order::orderBy('oId','DESC')->first();

        foreach($carts as $cart){
            $sum = $cart[3]*$cart[4];
            DB::insert('insert into orderitems(oId, cId, name, quantity, sum) values (?,?,?,?,?)', 
                [$firstOrder['oId'], session('id'), $cart[1], $cart[4], $sum] );
        }

        $request->session()->forget('carts');
        return redirect()->route('orders');
    }

    public function orders(){
            $orders = orderitem::where('orderitems.cId', session('id'))
                    ->leftJoin('orders', 'orderitems.oId', '=', 'orders.oId')
                    ->select('name', 'quantity', 'sum', 'status', 'date')->get();
            $data = ['orders'=>$orders];
            return view('orders',$data);
    }

}
