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

        <span id="guest">
        <a href="members" class="btn btn-outline-light btn-sm">你好！{{ Session::get('admin_login') }}</a> 
    </span>
    
    </div>
</nav>