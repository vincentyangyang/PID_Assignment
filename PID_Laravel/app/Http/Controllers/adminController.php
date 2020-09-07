<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Customer;
use App\Order;
use App\Orderitem;
use App\Good;
use Illuminate\Support\Facades\DB;
use View;

class adminController extends Controller
{
    public function login(Request $request){
        if($request->input('logout')){
            $request->session()->forget('admin_login');
            $request->session()->forget('admin_id');
            return redirect()->route('admin.login');
        }

        if(session('admin_login')){
            return redirect()->route('admin.members');
        }

        return view('admin_login');
    }


    public function loginPost(Request $request){
        $acc = $request->input('admin');
        $admin = Admin::where('admin',$acc)->where('password',$request->input('pass'))->first();

        if($admin){
            // $re = password_verify($request->input('pass'),$admin['password']);

            session(["admin_login"=>$acc]);
            return 'success';
        }else{
            return 'fail';
        }
    }

    public function members(Request $request){
        if(!session('admin_login')){
            return redirect()->route('admin.login');
        }

        if(!is_null($request->input('authority'))){
            DB::update('update customers set authority = ? where cId = ?', 
                [$request->input('authority'), $request->input('id')]);
            return redirect()->route('admin.members');
        }

        $customers = Customer::all();
        $data = ['customers'=>$customers];

        return View::make('admin_members',$data);
    }

    public function member_orders(Request $request){
        if(!session('admin_login')){
            return redirect()->route('admin.login');
        }

        $orders = orderitem::where('orderitems.cId', $request->input('id'))
            ->leftJoin('orders', 'orderitems.oId', '=', 'orders.oId')
            ->select('orders.cId', 'name', 'quantity', 'sum', 'status', 'date')->get();

        $customer = Customer::where('cId', $request->input('id'))->first();
        $data = ['orders'=>$orders, 'name'=>$customer['admin'] ];

        return view('admin_member_orders',$data);
    }

    public function goods(){
        if(!session('admin_login')){
            return redirect()->route('admin.login');
        }

        $goods = Good::get();
        $data = ['goods'=>$goods];

        return view('admin_goods',$data);
    }

    public function goods_action(Request $request){
        if(!session('admin_login')){
            return redirect()->route('admin.login');
        }

        if($request->input('id')){
            $good = Good::where('gId', $request->input('id'))->first();
            $data = ['row'=>$good];

            return view('admin_edit_goods',$data);
        }
        else{
            return view('admin_edit_goods');
        }
        
        
    }

    public function add_good(Request $request){
        if(!session('admin_login')){
            return redirect()->route('admin.login');
        }

            $file = $request->file('file');

            date_default_timezone_set("Asia/Shanghai");
            $pm = date("Ymd").(date("h")+12);
            $dateTime = (date("a")=="pm") ? $pm.date(":i:s"):date("Ymdh:i:s");
            $name = $dateTime.'.'.$file->getClientOriginalExtension();

            $file->move('../public/bower/image/', $name);

            DB::insert('insert into goods(name, price, description, image) values (?,?,?,?)', 
                [$request->input('name'), $request->input('price'), $request->input('description'), $name] );
    }


    public function edit_good(Request $request){
        if(!session('admin_login')){
            return redirect()->route('admin.login');
        }

        //更新商品資料到資料庫(相片有更新)
        if($request->input('update')){
            $file = $request->file('file');

            date_default_timezone_set("Asia/Shanghai");
            $pm = date("Ymd").(date("h")+12);
            $dateTime = (date("a")=="pm") ? $pm.date(":i:s"):date("Ymdh:i:s");
            $name = $dateTime.'.'.$file->getClientOriginalExtension();
    
            $file->move('../public/bower/image/', $name);
    
            DB::update('update goods set name = ?,price = ?,image = ?,description = ? where gId = ?', 
                [$request->input('name'), $request->input('price'), $request->input('description'), $request->input('id')] );                

        }

        //更新商品資料到資料庫(相片無更新)
        if($request->input('imageNoChange')){
            DB::update('update goods set name = ?,price = ?,image = ?,description = ? where gId = ?', 
                [$request->input('name'), $request->input('price'), $request->input('description'), $request->input('id')] );   
        }
    }

    public function image_ajax(Request $request){
        if(!session('admin_login')){
            return redirect()->route('admin.login');
        }

            $file = $request->file('file');

            date_default_timezone_set("Asia/Shanghai");
            $pm = date("Ymd").(date("h")+12);
            $dateTime = (date("a")=="pm") ? $pm.date(":i:s"):date("Ymdh:i:s");

            $name = $dateTime.'.'.$file->getClientOriginalExtension();

            $file->move('../public/bower/storage/', $name);

            return $name;

    }


}
