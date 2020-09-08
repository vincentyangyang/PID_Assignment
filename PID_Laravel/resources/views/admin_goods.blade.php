@extends('layouts.master_admin')

@section('title','商品資料')

@section('content')
    <div style="margin-top: 30px;" class="container col-12">

        <h2 align="center" style="padding-top:20px;">商品資料</h2>

        <span class="float-right" >
            <a class="btn btn-info" href="goods_action">新增</a>
        </span>
       
        <table style="margin-top: 50px;" class="table table-hover table-striped">

            <thead>
                <tr>
                    <th>商品</th>
                    <th style="width:455px;">名稱</th>
                    <th style="width:80px;">價錢</th>
                    <th style="width:505px;">說明</th>
                </tr>
            </thead>

            <tbody>
                @forelse($goods as $row)
                    <tr>
                        <td><img src="../../storage/app/public/image/{{ $row['image'] }}" style="width:210px;height:210px;" alt=""></td>
                        <td>{{ $row['name'] }}</td>
                        <td>{{ $row['price'] }}</td>
                        <td>{!! $row['description'] !!}</td>
                        <td>
                            <span class="float-right">
                              <a class="edit btn btn-outline-success btn-sm" href="goods_action?id={{ $row['gId'] }}">修改</a>
                              <a class="edit btn btn-outline-success btn-sm" href="javascript:void(0)" onclick="goDelete({{ $row['gId'] }})">刪除</a>
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
    $('.goods').addClass("active");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    function goDelete(id){
        $.ajax({
            type: "post",
            url: "{{ route('admin.goods') }}",
            data: {id: id}
        }).then(function(e){
            parent.location.reload();
        })
    }
@endsection