<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin :: @yield('title')</title>
    <link rel="favicon" href="/favicon.ico">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/all.css">
    <link rel="stylesheet" href="/css/Chart.min.css">
    <link rel="stylesheet" href="/css/style.css">

    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/script.js"></script>
</head>
<body>
<div class="">
    <div id="hamburger" class="navigation-menu">
        <svg width="20px" height="20px" viewBox="0 0 69 51" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke="none" stroke-width="1" fill-rule="evenodd">
                <g fill-rule="nonzero" stroke="none">
                    <g>
                        <rect x="0" y="0" width="69" height="6.2072333" rx="3.10361665"></rect> <rect x="0" y="22" width="69" height="6.2072333" rx="3.10361665"></rect> <rect x="0" y="44.7927667" width="69" height="6.2072333" rx="3.10361665"></rect>
                    </g>
                </g>
            </g>
        </svg>
    </div>
    <nav class="nav nav-sidebar">
        <div class="nav_section">
            <div class="nav_section_content company">
                <div class="nav_item prelative">
                    <a href="" class="nav_flex">
                            <span class="company-icon d-flex justify-content-center">
                             <img src="/img/favicon.png" class="img-fluid" />
                            </span>
                        <span class="company_text font-weight-bold">Updel Admin</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="nav_section margin-fix scroll-menu">
            <div class="nav_section_content">
                <div class="nav_item prelative">
                    <a href="/dashboard" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/dashboard')}}">
                           <span class="nav_link_icon">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                           </span>
                        <span class="nav_link_text">Dashboard</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/profile" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/profile')}}">
                           <span class="nav_link_icon">
                            <i class="fas fa-fw fa-user"></i>
                           </span>
                        <span class="nav_link_text">Profile</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/authorize" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/authorize')}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-qrcode"></i>
                            </span>
                        <span class="nav_link_text">Authorize Delivery</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/managers" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/managers')}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-user-shield"></i>
                            </span>
                        <span class="nav_link_text">Managers</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/support_staff" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/support_staff')}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-headset"></i>
                            </span>
                        <span class="nav_link_text">Customer service</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/riders" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/riders')}}">
                        <span class="nav_link_icon">
                         <i class="fas fa-fw fa-motorcycle"></i>
                        </span>
                        <span class="nav_link_text">Riders</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/staff" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/staff')}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-user-plus"></i>
                            </span>
                        <span class="nav_link_text">New staff</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/district_routes" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/district_routes')}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-paper-plane"></i>
                            </span>
                        <span class="nav_link_text">Districts/Routes</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/assign_routes" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/assign_routes')}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-route"></i>
                            </span>
                        <span class="nav_link_text">Assign Routes</span>
                    </a>
                </div>

                <div class="nav_item prelative">
                    <a href="/orders" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/orders')}}">
                         <span class="nav_link_icon">
                          <i class="fas fa-fw fa-truck"></i>
                         </span>
                        <span class="nav_link_text">Orders</span>
                    </a>
                </div>

                <div class="nav_item prelative">
                    <a href="/create_order" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/create_order')}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-shipping-fast"></i>
                            </span>
                        <span class="nav_link_text">New Order</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/pot" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/pot')}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-trash-restore"></i>
                            </span>
                        <span class="nav_link_text">Pot</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/settings" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/settings')}}">
                            <span class="nav_link_icon">
                             <i class="fas fa-fw fa-cogs"></i>
                            </span>
                        <span class="nav_link_text">Settings</span>
                    </a>
                </div>
                <div class="nav_item prelative">
                    <a href="/logout" class="nav_link nav_flex {{\App\Classes\Menu::is_active('/logout')}}">
                         <span class="nav_link_icon">
                          <i class="fas fa-fw fa-sign-out-alt"></i>
                         </span>
                        <span class="nav_link_text">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>
<header class="d-flex">
    <div class="header-page-title mr-auto">
        <div class="icon-block blue-bg">
            <i class="fas fa-fw @yield('icon')"></i>
        </div>
        <span class="header-page-title-text">@yield('title')</span>
    </div>

    <div class="header-nav">
            <span class="header-nav-item">
                <img class="avatar rounded-circle img-thumbnail img-fluid" src="/{{\App\Classes\Session::get('pics')}}" alt="profile pics">
{{--            <p class="avatar">Hi! Noble</p>--}}
            </span>
        <div class="nav-dropdown">
            <div class="nav-dropdown-item">
                <a href="/profile">
                    <div class="nav-dropdown-item-link">
                        Profile
                    </div>
                </a>
            </div>
            <div class="nav-dropdown-item">
                <a href="/settings">
                    <div class="nav-dropdown-item-link">
                        Settings
                    </div>
                </a>
            </div>
            <div class="nav-dropdown-item">
                <a href="/logout">
                <div class="nav-dropdown-item-link">
                    Logout
                </div>
                </a>
            </div>
        </div>
    </div>
</header>
<main class="main" id="main">
    <div class="main_container">
    @yield('content')
    </div>
</main>

<script>
    let ctx = $('#contribution-canvas');
</script>

</body>
</html>