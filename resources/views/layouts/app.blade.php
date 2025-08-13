<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '機車出租網站')</title>

    <!-- 這是 favicon.png -->
    <link rel="icon" href="{{ asset('images/backend_favicon.png') }}" type="image/png">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-bicycle"></i> 機車出租
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">首頁</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('motorcycles.index') }}">機車列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('stores.index') }}">商店資訊</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">聯絡我們</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    @if (Auth::guard('member')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3"></i> 購物車
                                @php
                                    $cart = \App\Models\Cart::getCurrentCart();
                                    $itemCount = $cart->getItemCount();
                                @endphp
                                @if ($itemCount > 0)
                                    <span class="badge bg-danger">{{ $itemCount }}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                    @if (Auth::guard('member')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::guard('member')->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">個人資料</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">我的訂單</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('member.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">登出</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('member.login') }}">登入</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('member.register') }}">註冊</a>
                        </li>
                    @endauth
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="/backend" target="_blank">
                            <i class="bi bi-gear"></i> 後台管理
                        </a>
                    </li> --}}
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="py-4">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>機車出租網站</h5>
                <p>提供優質的機車出租服務，讓您的旅程更加便利。</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>聯絡資訊</h5>
                <p>
                    <i class="bi bi-telephone"></i> 0800-123-456<br>
                    <i class="bi bi-envelope"></i> info@rentbike.com
                </p>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <p>&copy; {{ date('Y') }} 機車出租網站. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-MXe5EK5gyK+fbhwQy/dukwz9fw71HZcsM4KsyDBDTvMyjymkiO0M5qqU0lF4vqLI4VnKf1+DIKf1GM6RFkO8PA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@stack('scripts')
</body>

</html>
