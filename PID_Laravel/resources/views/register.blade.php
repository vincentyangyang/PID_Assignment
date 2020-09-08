@extends('layouts.master2')

@section('title','用戶登錄')
@section('url','register')

@section('css')
      .fail{
          font-size: 13px;
          color: red;
      }

      #exist{
          color: red;
      }
@endsection

@section('content')
    <div style="margin-top: 50px;" class="container">

        <form method="post">

            <div id="divadmin" class="form-group row">
                <label for="admin" class="col-4 col-form-label"><span class="float-right"">帳號</span></label> 
                <div class="col-8">
                    <input id="admin" name="admin" type="text" class="form-control col-5" value="" placeholder="請輸入至少7碼的英文或數字" pattern="\w{7,}">
                </div>
            </div>

            <div id="divpass" class="form-group row">
                <label for="pass" class="col-4 col-form-label"><span class="float-right">密碼</span></label> 
                <div class="col-8">
                    <input id="pass" name="pass" type="password" class="form-control col-5" value="" placeholder="請輸入至少7碼的英文或數字" pattern="\w{7,}">
                </div>
            </div>

            <div id="divemail" class="form-group row">
                <label for="email" class="col-4 col-form-label"><span class="float-right">信箱</span></label> 
                <div class="col-8">
                    <input id="email" name="email" type="text" class="form-control col-5" placeholder="xxx@xxx.com" pattern="\w+([.-]\w+)*@\w+([.-]\w+)+" value="">
                </div>
            </div>

            <div id="divbirthday" class="form-group row">
                <label for="birthday" class="col-4 col-form-label"><span class="float-right">生日</span></label> 
                <div class="col-8">
                    <input id="birthday" name="birthday" type="text" class="form-control col-5" placeholder="2000-01-01" value="" pattern="\d{4}-\d{2}-\d{2}">
                </div>
            </div>

            <div id="divphone" class="form-group row">
                <label for="phone" class="col-4 col-form-label"><span class="float-right">手機</span></label> 
                <div class="col-8">
                    <input id="phone" name="phone" type="text" class="form-control col-5" value="" placeholder="0912345678" pattern="\d{10}">
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button id="register" name="submit" value="OK" type="button" class="btn btn-success">註冊</button>
                    <input type="button" id="cancel" name="cancel" value="清除" class="btn btn-success"></button>
                </div>
                
            </div>

        </form>
  
    </div>

    <div id="exist" class='text-center'></div>

    <div class="footer fixed-bottom">
      Chung Yo© 2020. All Rights Reserved
    </div>
@endsection

@section('script')
    $('#cancel').on('click',function(){
        $(".fail").remove();
        $('#exist').html("");
        $('.form-control').val("");
    });

    $('#register').on('click',function(){

        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //判斷格式是否正確-------------------------------------------------------

        var acc = /\w{7,}/;
        var mail = /\w+([.-]\w+)*@\w+([.-]\w+)+/;
        var bd = /\d{4}-\d{2}-\d{2}/;
        var tel = /^\d{10}$/;

        var admin = $('#admin').val();
        var pass = $('#pass').val();
        var email = $('#email').val();
        var birthday = $('#birthday').val();
        var phone = $('#phone').val();

        var format = [acc.test(admin),acc.test(pass),mail.test(email),bd.test(birthday),tel.test(phone)];
        var column = ["admin","pass","email","birthday","phone"];
        var columnName = ["帳號","密碼","信箱","生日","電話"];

        $(".fail").remove();
        $('#exist').html("");

        var i;
        var flag = 0;

        for(i=0;i<5;i++){
            if (format[i] == false){
              flag = 1;
              var divName = "div"+column[i];
              $("#"+divName).append("<div class='text-center col-10 fail'>"+columnName[i]+"格式錯誤！！</div>");
            }
        }
      
        //------------------------------------------------------------------------

        if(flag == 0){
            var dataList = {
                admin: admin,
                pass: pass,
                email: email,
                birthday: birthday,
                phone: phone
            }

            $.ajax({
                type: "POST",
                url: "{{ route('registerPost') }}",
                data: dataList,
                success: function(e){
                    if(e == 'exist'){
                      $('#exist').html("帳號已存在！！");
                    }else{
                      window.location.replace("{{ route('login') }}");
                    }
                }
            })
        }

    })
@endsection