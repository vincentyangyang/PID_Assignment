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

    public function goods(Request $request){
        if(!session('admin_login')){
            return redirect()->route('admin.login');
        }
        if($request->input('id')){
            $imageName = Good::where('gId', $request->input('id'))->first();
            unlink(storage_path('app/public/image/').$imageName['image']);
            DB::delete('delete from goods where gId= ?',[$request->input('id')]);
            
            return 'success';    
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
            $data = ['row'=>$good, 'action'=>'修改'];

            return view('admin_edit_goods',$data);
        }
        else{
            return view('admin_edit_goods',['action'=>'新增']);
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
            $dateTime = str_replace(":","_",$dateTime);
            $name = $dateTime.'.'.$file->getClientOriginalExtension();
            
            $file->storeAs('public/image', $name);

            DB::insert('insert into goods(name, price, description, image) values (?,?,?,?)', 
                [$request->input('name'), $request->input('price'), $request->input('description'), $name] );
            
            //刪除暫存檔
            $files = glob(storage_path('app/public/storage/*'));
            foreach($files as $file){
                if(is_file($file))
                    unlink($file);
            }
    }


    public function edit_good(Request $request){
        if(!session('admin_login')){
            return redirect()->route('admin.login');
        }

        //更新商品資料到資料庫(相片有更新)
        if($request->input('update')){
            $imageName = Good::where('gId', $request->input('id'))->first();

            $file = $request->file('file');

            date_default_timezone_set("Asia/Shanghai");
            $pm = date("Ymd").(date("h")+12);
            $dateTime = (date("a")=="pm") ? $pm.date(":i:s"):date("Ymdh:i:s");
            $dateTime = str_replace(":","_",$dateTime);
            $name = $dateTime.'.'.$file->getClientOriginalExtension();

            $file->storeAs('public/image', $name);

            DB::update('update goods set name = ?,price = ?,image = ?,description = ? where gId = ?', 
                [$request->input('name'), $request->input('price'), $name, $request->input('description'), $request->input('id')] );                
            
            //刪除之前的圖片及暫存檔
            unlink(storage_path('app/public/image/').$imageName['image']);
            $files = glob(storage_path('app/public/storage/*'));
            foreach($files as $file){
                if(is_file($file))
                    unlink($file);
            }

        }

        //更新商品資料到資料庫(相片無更新)
        if($request->input('imageNoChange')){
            DB::update('update goods set name = ?, price = ?, description = ? where gId = ?', 
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
            $dateTime = str_replace(":","_",$dateTime);
            $name = $dateTime.'.'.$file->getClientOriginalExtension();

            $file->storeAs('public/storage', $name);

            return $name;
    }

    public function canvas(Request $request){
        if(!session('admin_login')){
            return redirect()->route('admin.login');
        }
        date_default_timezone_set("Asia/Shanghai");


        if($request->input('id')){
            $id = $request->input('id');
            if($id == 1){
                $time = date("Y-m-d 00:00:00");
                $time2 = date("Y-m-d 23:59:59");

                $datas = DB::select("select name, sum(quantity) as quantity from orderitems where oId in (select oId from orders where date between ? and ?) GROUP BY(name)",
                    [$time,$time2]);

                $data = json_decode(json_encode($datas), true);
                $data = ['range'=>'今日','data'=>$data];

            }elseif($id == 2){
                $time = date("Y-m-d",strtotime("-1 day"))." 00:00:00";
                $time2 = date("Y-m-d 23:59:59");

                $datas = DB::select("select name, sum(quantity) as quantity from orderitems where oId in (select oId from orders where date between ? and ?) GROUP BY(name)",
                [$time,$time2]);

                $data = json_decode(json_encode($datas), true);
                $data = ['range'=>'最近7天','data'=>$data];

            }elseif($id == 3){
                $time = date("Y-m-d",strtotime("last month"))." 00:00:00";
                $time2 = date("Y-m-d 23:59:59");

                $datas = DB::select("select name, sum(quantity) as quantity from orderitems where oId in (select oId from orders where date between ? and ?) GROUP BY(name)",
                [$time,$time2]);

                $data = json_decode(json_encode($datas), true);
                $data = ['range'=>'最近1個月','data'=>$data];

            }         
        }else{
            $datas = DB::select('select name, sum(quantity) as quantity from orderitems GROUP BY(name)');

            $data = json_decode(json_encode($datas), true);
            $data = ['range'=>'請選擇區間','data'=>$data];
        }


        
        return view('canvas',$data);
    }


}
