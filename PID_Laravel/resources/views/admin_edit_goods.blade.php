<!DOCTYPE html>
    <html lang="en">
    <head>
      
      <title>{{ $action }}商品資訊</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <link rel="stylesheet" href="{{ asset('bower/bootstrap/dist/css/bootstrap.min.css') }}">
      <script src="{{ asset('bower/jquery/dist/jquery.min.js') }}"></script>
      <script src="{{ asset('bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>


    </head>

    <style>
      body{
        background-color: #ECFFFF;
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

      .textarea {
        height: 200px;
        width: 300px;
        padding: 4px;
        border: 1px solid #888;
        resize: vertical;
        overflow: auto;
        }
        .textarea:empty:before {
        content: attr(placeholder);
        color: #bbb;
      }
    
    </style>
    
<body>


  <nav class="navbar navbar-expand-md navbar-dark bg-primary">

    <a href="http://localhost:8000/PID_Assignment/PID_Laravel/public/admin/members" class="navbar-brand">管理</a>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">

      <ul class="navbar-nav">

        <li class="nav-item member">
          <a href="members" class="nav-link">會員資料</a>
        </li>

        <li class="nav-item goods">
          <a href="goods" class="nav-link">商品資料</a>
        </li>

        <li class="nav-item canvas">
          <a href="canvas" class="nav-link">銷售數據</a>
        </li>

        <li class="nav-item">
          <a href="./?logout=1" class="nav-link">登出</a>
        </li>

      </ul>

      <span id="guest"> <a href="members" class="btn btn-outline-light btn-sm">你好！{{ Session::get('admin_login') }}</a> </span>
    </div>
  </nav>

<div style="margin-top: 30px;" class="container">

<h2 align="center" style="padding-top:20px;">{{ $action }}商品資訊</h2>

<div style="margin-top: 50px;" class="container col-8">
        <form method="get" id="form">

        @if(!empty($row))
            <div class="form-group row">
                <label for="name" class="col-4 col-form-label">品名</label> 
                <div class="col-8">
                    <input id="name" name="name" type="text" class="form-control" value="{{ $row['name'] }}">
                </div>
                <div id="errorName" class='text-center col-11' style="display:none;color:red;font-size:13px;">商品名稱不得為空</div>
            </div>

            <div class="form-group row">
                <label for="price" class="col-4 col-form-label">價錢</label> 
                <div class="col-8">
                    <input id="price" name="price" type="text" class="form-control" pattern="\d+" value="{{ $row['price'] }}">
                </div>
                <div id="errorPrice" class='text-center col-11' style="display:none;color:red;font-size:13px;">價錢必須為數字且不為0</div>
            </div>

            <div class="form-group row">
                <label for="image" class="col-2 col-form-label" style="height:50px;padding-right: 0px;">圖片
                  <p style="color:blue;font-size:10px;">(點擊此處以上傳)</p>
                </label> 
                <div class="col-8">
                    <img id="photo" src="../../storage/app/public/image/{{ $row['image'] }}" class="col-12" style="border-style: outset;margin-left: 122px;"  >
                    <input id="image" name="image" style="display: none;" accept="image/*" type="file" onchange="setImage()" class="form-control" value="image/{{ $row['image'] }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-4 col-form-label">說明</label> 
                <div class="col-8">
                  <textarea name="" id="description" cols="45" rows="10"></textarea>
                </div>
            </div>


            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button id="submit" name="" value="OK" type="button" onclick="goEdit({{ $row['gId'] }})" class="btn btn-success">送出</button>
                    <a href="goods" class="btn btn-success">取消</a>
                </div>
                
            </div>
        @else
            <div class="form-group row">
                <label for="name" class="col-4 col-form-label">品名</label> 
                <div class="col-8">
                    <input id="name" name="name" type="text" class="form-control">
                </div>
                <div id="errorName" class='text-center col-11' style="display:none;color:red;font-size:13px;">商品名稱不得為空</div>
            </div>

            <div class="form-group row">
                <label for="price" class="col-4 col-form-label">價錢</label> 
                <div class="col-8">
                    <input id="price" name="price" type="text" class="form-control" pattern="\d+">
                </div>
                <div id="errorPrice" class='text-center col-11' style="display:none;color:red;font-size:13px;">請輸入有效價錢且不為0</div>
            </div>

            <div class="form-group row">
                <label for="image" class="col-2 col-form-label" style="height:50px;padding-right: 0px;">圖片
                  <p style="color:blue;font-size:10px;">(點擊此處以上傳)</p>
                </label> 
                <div class="col-8">
                    <img id="photo" src="../../storage/app/public/image/none.jpeg" class="col-12" style="border-style: outset;margin-left: 122px;"  >
                    <input id="image" name="image" style="display: none;" accept="image/*" type="file" onchange="setImage()" class="form-control" value="../../storage/app/public/image/none.jpeg">
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-4 col-form-label">說明</label> 
                <div class="col-8">
                  <textarea name="" id="description" cols="45" rows="10"></textarea>
                </div>
            </div>


            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button id="submit" name="" value="OK" type="button" onclick="goEdit(0)" class="btn btn-success">送出</button>
                    <a href="goods" class="btn btn-success">取消</a>
                </div>
                
            </div>
        @endif
        </form>

    </div>



</div>

<script>

    $('.goods').addClass("active");

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })


    //填入商品詳細前<br>換\n
    @if(!empty($row))
    var description = "{{ $row['description'] }}";

    if(description != ""){
      description = description.replace(/&lt;br&gt;/g,"\n");
      $("#description").val(description);
    }
    @endif



    //新增or修改
    function goEdit(id){
      $("#errorPrice").hide();
      $("#errorName").hide();

      if($('#name').val() !== ""){
        var r = /^([1-9][0-9]*)$/;
        if(r.test($('#price').val())){

          //新增資料
          if (id == 0){
              if(typeof $('#image').prop('files')[0] !== "undefined"){

                var name = $('#name').val();
                var price = $('#price').val();
                var image = $('#image').val();
                var description = $('#description').val().replace(/\n/g, '<br>');
                var file_data = $('#image').prop('files')[0];   //取得上傳檔案屬性
                var form_data = new FormData();  //建構new FormData()

                form_data.append('name', name);
                form_data.append('price', price);
                form_data.append('image', image);
                form_data.append('description', description);
                form_data.append('file', file_data);
                form_data.append('insert', "insert");
                

                $.ajax({
                  type: "post",
                  url: "add",
                  contentType: false,
                  cache: false,
                  processData: false,
                  data: form_data
                }).then(function(e){
                    $("#photo").prop("src","../../storage/app/public/image/none.jpeg");
                    $('#form').trigger("reset");
                    alert("新增成功");

                })
              }else{
                alert("請選擇圖片！！");
              }

          }
          //修改資料
          else{

              var name = $('#name').val();
              var price = $('#price').val();
              var image = $('#image').val();
              var description = $('#description').val().replace(/\n/g, '<br>');
              var form_data = new FormData();  //建構new FormData()

              form_data.append('id', id);
              form_data.append('name', name);
              form_data.append('price', price);
              form_data.append('image', image);
              form_data.append('description', description);
              

              //相片無修改時
              if(typeof $('#image').prop('files')[0] == "undefined"){

                form_data.append('imageNoChange', "imageNoChange");

                $.ajax({
                  type: "post",
                  url: "edit",
                  contentType: false,
                  cache: false,
                  processData: false,
                  data: form_data
                }).then(function(e){
                  window.location.replace("goods")
                })
              }

              //相片有更新
              else{
                  var file_data = $('#image').prop('files')[0];   //取得上傳檔案屬性
                  
                  form_data.append('file', file_data);
                  form_data.append('update', "update");

                  $.ajax({
                    type: "post",
                    url: "edit",
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: form_data
                  }).then(function(e){
                    window.location.replace("goods")
                  })
              }
          }
        }else{
          //價格格式錯誤
          $("#errorPrice").show();
        }
      }else{
        //名稱為空
        $("#errorName").show();
      }


    }

    // ----------------------------------------------------

    
    //選取照片預覽到網頁上
    function setImage(){
      var file_data = $('#image').prop('files')[0];   //取得上傳檔案屬性
        var form_data = new FormData();  //建構new FormData()
        form_data.append('file', file_data);  //吧物件加到file後面
        form_data.append('change', "change");  //吧物件加到file後面
            
        $.ajax({
            type: "post",
            url: "image_ajax",
            contentType: false,
            cache: false,
            processData: false,
            data: form_data,
            success: function(e){
              $("#photo").prop("src","../../storage/app/public/storage/"+e);
            }
        })
    }


</script>

</body>
</html>
