<ul class="nav navbar-nav">
    <li><a href="/">主页</a></li>
    @if (Auth::check())
        <li @if (Request::is('admin/goods_manage*')) class="active" @endif>
            <a href="/admin/goods_manage">商品管理</a>
        </li>
        <li @if (Request::is('admin/banner*')) class="active" @endif>
            <a href="/admin/banner">幻灯片</a>
        </li>
<!--         <li @if (Request::is('admin/upload*')) class="active" @endif>
            <a href="/admin/upload">Uploads</a>
        </li>
 -->    @endif 
</ul>

<ul class="nav navbar-nav navbar-right">
    @if (Auth::guest())
        <li><a href="/auth/login">Login</a></li>
    @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
                    aria-expanded="false">
                {{ Auth::user()->name }}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/auth/logout">Logout</a></li>
            </ul>
        </li>
    @endif
</ul>