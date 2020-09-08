<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>商品詳情</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('bower/bootstrap/dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('bower/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>


    <style>
      body{
		background-color: #ECFFFF;
        padding: 0;
        margin: 0;
      }
      .navbar-nav{
      margin-left: 60px;
      }

      #guest{
		position: absolute;
		right: 50px;
		color: white;
	  } 


      .fixed-bottom {
        position: fixed;
        bottom: 0;
        width:100%;
      }

      .title {
		font-size: 20px;
		color: #FF6600;
		font-style: italic;
		margin-top: 50px;
	    }

        .add_cart{
            float: right;
        }

    </style>
</head>

<body>


<nav class="navbar navbar-expand-md navbar-dark bg-primary">

  <a href="http://localhost:8000/PID_Assignment/PID_Laravel/public/goodsList" class="navbar-brand">商城</a>

  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarCollapse">

    <ul class="navbar-nav">

    <li class="nav-item cart">
        <a href="cart" class="nav-link">購物車</a>
      </li>

      <li class="nav-item list">
        <a href="goodsList" class="nav-link">商品列表</a>
      </li>

      <li class="nav-item">
        <a href="./?logout=1" class="nav-link">{!! !empty(Session::get('login')) ? '登出':'登入/註冊' !!}</a>
      </li>

    </ul>

    <span id="guest"> <a href="orders" class="btn btn-outline-light btn-sm">你好！{{ Session::get('login') }}</a> </span>
  </div>
</nav>

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
						<img src="bower/image/add_to_cart.png" style="width:185px; height:50px;"></a>
				</div>
			</td>
		</tr>
</table>


<script type="text/javascript">

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


</script>




</script>
</body>
</html>