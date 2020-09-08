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