@extends('layouts.master')

@section('title','購物車')

@section('css')
    table {
      border-collapse: collapse;
    }

    .threeboder {
        border: 1px solid #5B96D0;
    }

    .trow {
        border-right: 1px solid #5B96D0;
        border-bottom: 1px solid #5A96D6;
    }

    .theader {
        background-color: #A5D3FF;
        font-size: 14px;
        border-right: 1px solid #5B96D0;
        border-bottom: 1px solid #5A96D6;
    }
@endsection

@section('content')
    <h2 align="center" style="padding-top:20px;">購物車</h2>

    <form id="form" action="cartPost" method="POST" class="col-11" style="margin: auto;">
        @csrf
        <br>
        <table width="100%" border="1" align="center" class="threeboder">
            <tr bgcolor="#A5D3FF">
                <td height="50" align="center" class="theader" colspan="2">商品名稱</td>
                <td width="8%" align="center" class="theader">數量</td>
                <td width="15%" align="center" class="theader">單價</td>
                <td width="15%" align="center" class="theader">小計</td>
                <td width="5%" align="center" class="theader">清除</td>
            </tr>
        
            @forelse($carts as $cart)
                <tr style="height:150px;"> 
                    <td><img src="../storage/app/public/image/{{ $cart[2] }}" style="width:100px; height:100px;" /></td>
                    <td height="50" align="left" class="trow"> {{ $cart[1] }} </td>
                    <td align="center" class="trow">
                        <input id="quantity" type="text" value="{{ $cart[4] }}" onblur="calc({{ $cart[0] }},'{{ $cart[1] }}','{{ $cart[2] }}',{{ $cart[3] }},this)">
                    </td>
                    <td align="center" class="trow"><span>{{ $cart[3] }}</span></td>
                    <td align="center" class="trow"><span>{{ $cart[5] }}</span></td>
                    <td class="text-center"><a class="btn btn-outline-success btn-sm" href="javascript:void(0)" 	onclick="addToCart({{ $cart[0] }},'{{ $cart[1] }}','{{ $cart[2] }}','{{ $cart[3] }}',0,'cart')">刪除</a></td>
                </tr>
            @empty
            @endforelse

            <tr>
                <td height="50" colspan="6" align="right">合計：$<span id="total">{{ $total }}</span>  </td>
            </tr>
        </table>

        <br>

        <div align="center">
            <button id="checkout" name="total" value="{{ $total }}" type="submit" class="btn btn-success">結帳</button>
        </div>
    
    </form>
@endsection

@section('script')
    //讓Enter無效
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    }); 

    //判斷是否登入
    if ( "{{ Session::get('login') }}" == "" ){
        alert("請先登入！！");
        $('body').html("");
        history.go(-1);
    }

    $('.cart').addClass("active");

		$.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        
    //刪除商品
    function addToCart(id,name,image,price,quantity,page){
        var dataList = {
            id: id,
            name: name,
            image: image,
            price: price,
            quantity: quantity,
            page: page
        }
          
        $.ajax({
            type: "POST",
            url: "{{ route('addPost') }}",
            data: dataList
        }).then(function(e){
            parent.location.reload();
        })
	  }


    //當商品更改數量
    function calc(id,name,image,price,quantityInput) {
        var dataList = {
            id: id,
            name: name,
            image: image,
            price: price,
            quantity: quantityInput.value,
            page: 'cart'
        }

        var quantity = dataList['quantity'];
        var r = /^(0|[1-9][0-9]*)$/;

        if (r.test(quantity)){
            $.ajax({
                type: "POST",
                url: "{{ route('addPost') }}",
                data: dataList
            }).then(function(e){
                parent.location.reload();
            })
        }else{
            alert("請填入有效數值！！");
            parent.location.reload();
        }

    }

    $('#checkout').on('click',function(event){
        @if( empty($carts) )
            alert('購物車內沒有商品');
            event.preventDefault();
            return false;
        @else
            $('form').submit();
        @endif
    })
@endsection