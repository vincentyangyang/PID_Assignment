@extends('layouts.master')

@section('title','商品詳細資訊')

@section('css')
    .title {
        font-size: 20px;
        color: #FF6600;
        font-style: italic;
        margin-top: 50px;
	  }

    .add_cart{
        float: right;
    }
@endsection

@section('content')
    <div class="text3 title" align="center">{{ $good['name'] }}</div><br><br>
    <table width="100%" border="0" align="center">
        <tr>
            <td width="40%" align="right">
                <div><img src="../storage/app/public/image/{{ $good['image'] }}" width="360px" height="360px"/></div>
                <br>
            </td>

            <td>
                <div style="width:80%; height:200;">
                    <dl style="margin-left:100px;">
                        <dd style="width:25%;"><h4>特色：</h4></dd>
                        <dd style="width:70%; margin-left:30px;">{!! $good['description'] !!}</dd>
                    </dl>
                </div>

                <div align="center" class="text4">價格：<span class="title">{{ $good['price'] }}元</span></div>

                <br>

                <div style="float:left; margin-left:150px; margin-top:40px;">
                    <a class="add_cart" href="javascript:void(0)" 	onclick="addToCart({{ $good['gId'] }},'{{ $good['name'] }}','{{ $good['image'] }}','{{ $good['price'] }}',0,'list')">
                    <img src="../storage/app/public/image/add_to_cart.png" style="width:185px; height:50px;"></a>
                </div>
            </td>
        </tr>
    </table>
@endsection

@section('script')
    $('.list').addClass("active");

    function addToCart(id,name,image,price,quantity,page){
        $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        var dataList = {
          id: id,
          name: name,
          image: image,
          price: price,
          quantity: quantity,
          page: page
        }

        $.ajax({
            type: "post",
            url: "{{ route('addPost') }}",
            data: dataList
        }).then(function(e){
            alert("商品已加入購物車！！");
        })
    }
@endsection