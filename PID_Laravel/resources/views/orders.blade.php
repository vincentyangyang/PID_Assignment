@extends('layouts.master')

@section('title','訂單')

@section('content')
    <div style="margin-top: 30px;" class="container">

        <h2 align="center" style="padding-top:20px;">訂單記錄</h2>

        <span class="float-right" >
            <a class="btn btn-info" href="goodsList">首頁</a>
        </span>
             
        <table style="margin-top: 50px;" class="table table-hover table-striped">

            <thead>
                <tr>
                    <th>商品</th>
                    <th>數量</th>
                    <th>小計</th>
                    <th>付款狀態</th>
                    <th>訂單時間</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order['name'] }}</td>
                        <td>{{ $order['quantity'] }}</td>
                        <td>{{ $order['sum'] }}</td>
                        <td>{{ ($order['status']==0) ? '未付款':'已付款' }}</td>
                        <td>{{ $order['date'] }}</td>
                    </tr>
                @empty
                @endforelse
            </tbody>

        </table>

    </div>
@endsection

@section('script')
    //判斷是否登入
    if ( "{{ Session::get('login') }}" == "" ){
        alert("請先登入！！");
        $('body').html("");
        history.go(-1);
    }
@endsection