<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>首頁</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('bower/bootstrap/dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('bower/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	
	
	<style>
      body{
		background-color:	#ECFFFF;
        padding: 0;
        margin: 0;
      }


	  #page-container {
		position: relative;
		min-height: 100vh;
		}


      .navbar-nav{
      margin-left: 60px;
      }

	  #navbarCollapse{
		  position: relative;
	  }

	  #guest{
		position: absolute;
		right: 50px;
		color: white;
	  }

      h3{
		align: center;
	}

	.info{
		clear: both;

		height: 50px;
		margin:0px auto 50px;
	}


	.info .infoarea{
		float:left;
		padding:10px;
		height: 400px;
	}

	.info .infoarea img{
		width: 200px;
		margin-bottom: 10px;
	}

	.web{
		margin-bottom: 10px;
	}

	.pname{
		margin-bottom: 10px;
		height: 100px;
	}

	.info >p{
		font-size: 28px;
		padding-top: 20px;
		font-weight: bold;
	}

	ul{
		padding: 0;
	}


	li{
		list-style-type: none;
	}

	.price{
		width:135px;
		height:60px;
	}

	.by_accuracy{
		width:50px;
		height:60px;
		float:left;
	}

	.by_price{
		width:85px;
		height:60px;
	}

	.col3 {
		padding-top: 5px;
		text-align: center;
	}

	#goodsName{
		width: 210px;
		overflow:hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 3;
		-webkit-box-orient: vertical;
		white-space: normal;
	}



    </style>
</head>

<body>

<div id="page-container">

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

<h2 align="center" style="padding-top:20px; margin-bottom:22px;">商品列表</h2>

<div class='info'>

	@foreach($goods as $row)

		<div class='infoarea col-xs-4 col-sm-6 col-md-4 col-lg-3' style="height:470px;">

			<div style="height:380px;margin: auto;width: 240px;padding:0 20px;border-style: solid;border-width:1px;border-color: #BDB76B;">
				<ul>
					<li class="img"><a href="goodsDetail?id={{ $row['gId'] }}"><img src="../storage/app/public/image/{{ $row['image'] }}"/></a></li>
					<li class="pname" style="margin-bottom:0; height:80px;">
						<a href="goodsDetail?id={{ $row['gId'] }}">
							<p id="goodsName">{{ $row['name'] }}</p>
						</a>
					</li>
					<li>價格：{{ $row['price'] }}</li>
					<hr style="margin-bottom: 8px; margin-top: 8px;">
					<li class="col3" style="margin-top:3px;">
						<a id="add" class="add_cart" href="javascript:void(0)" 	onclick="addToCart({{ $row['gId'] }},'{{ $row['name'] }}','{{ $row['image'] }}','{{ $row['price'] }}',0,'list')">

							<img src="../storage/app/public/image/add_to_cart.png" style="width:110px; height:28px;">
						</a>
					</li>
				</ul>
			</div>

		</div>

	@endforeach

</div>

</div>


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
			// console.log(e);
			alert("商品已加入購物車！！");
		})
	}


</script>
</body>
</html>