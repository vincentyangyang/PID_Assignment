@extends('layouts.master_admin')

@section('title','會員資料')

@section('content')
    <div style="margin-top: 30px;" class="container">

        <h2 align="center" style="padding-top:20px;">會員資料</h2>
                    
        <table style="margin-top: 50px;" class="table table-hover table-striped">

            <thead>
                <tr>
                  <th>會員編號</th>
                  <th>會員帳號</th>
                  <th>E-mail</th>
                  <th>電話</th>
                  <th>權限</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td onclick="goOrder({{ $customer['cId'] }})">{{ $customer['cId'] }}</td>
                        <td onclick="goOrder({{ $customer['cId'] }})">{{ $customer['admin'] }}</td>
                        <td onclick="goOrder({{ $customer['cId'] }})">{{ $customer['email'] }}</td>
                        <td onclick="goOrder({{ $customer['cId'] }})">{{ $customer['phone'] }}</td>
                        <td id="status" onclick="goOrder({{ $customer['cId'] }})">
                            {{ $customer['authority']==1 ? '正常':'停權' }}
                        </td>
                        <td>
                            <span class="float-right">
                                <a class="authority btn btn-sm{{ $customer['authority']==1 ? ' btn-danger':' btn-outline-success' }}" href="members?id={{ $customer['cId'] }}&authority={{ $customer['authority']==1 ? 0:1 }}">{{ $customer['authority']==1 ? "停權":"恢復" }}</a>
                            </span>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>

        </table>

    </div>
@endsection

@section('script')
    $('.member').addClass("active");


    function goOrder(id){
        window.location.href="member_orders?id="+id;
    }
@endsection