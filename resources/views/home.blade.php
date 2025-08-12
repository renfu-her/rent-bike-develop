@extends('layouts.app')

@section('title', '首頁 - 機車出租網站')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row align-items-center py-5">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold text-primary mb-4">
                歡迎來到機車出租網站
            </h1>
            <p class="lead mb-4">
                提供優質的機車出租服務，讓您的旅程更加便利。我們擁有各種型號的機車，
                滿足您的不同需求。立即預約，享受便捷的租車體驗！
            </p>
            <div class="d-flex gap-3">
                <a href="{{ route('motorcycles.index') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-search"></i> 瀏覽機車
                </a>
                <a href="{{ route('stores.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-geo-alt"></i> 查看商店
                </a>
            </div>
        </div>
        <div class="col-lg-6">
            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                 alt="機車出租" class="img-fluid rounded shadow">
        </div>
    </div>

    <!-- Features Section -->
    <div class="row py-5">
        <div class="col-12 text-center mb-5">
            <h2 class="fw-bold">為什麼選擇我們？</h2>
            <p class="text-muted">我們提供最優質的服務和設備</p>
        </div>
        
        <div class="col-md-4 text-center mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-shield-check text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="card-title">安全可靠</h5>
                    <p class="card-text text-muted">
                        所有機車都經過定期保養和檢查，確保您的安全。
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 text-center mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-currency-dollar text-success" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="card-title">價格實惠</h5>
                    <p class="card-text text-muted">
                        提供合理的租車價格，讓您享受經濟實惠的租車服務。
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 text-center mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-clock text-info" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="card-title">24小時服務</h5>
                    <p class="card-text text-muted">
                        全天候提供租車服務，隨時滿足您的需求。
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="row py-5 bg-light rounded">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold">服務統計</h2>
        </div>
        
        <div class="col-md-3 text-center mb-3">
                               <div class="h2 text-primary fw-bold">{{ \App\Models\Motorcycle::where('status', 'available')->count() }}</div>
            <p class="text-muted">可出租機車</p>
        </div>
        
        <div class="col-md-3 text-center mb-3">
                               <div class="h2 text-success fw-bold">{{ \App\Models\Store::where('status', '啟用')->count() }}</div>
            <p class="text-muted">服務據點</p>
        </div>
        
        <div class="col-md-3 text-center mb-3">
            <div class="h2 text-info fw-bold">{{ \App\Models\Member::count() }}</div>
            <p class="text-muted">註冊會員</p>
        </div>
        
        <div class="col-md-3 text-center mb-3">
            <div class="h2 text-warning fw-bold">{{ \App\Models\Order::where('is_completed', true)->count() }}</div>
            <p class="text-muted">完成訂單</p>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="row py-5">
        <div class="col-12 text-center">
            <h2 class="fw-bold mb-4">準備開始您的旅程了嗎？</h2>
            <p class="lead mb-4">立即瀏覽我們的機車選擇，找到最適合您的座駕！</p>
            <a href="{{ route('motorcycles.index') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-right"></i> 立即預約
            </a>
        </div>
    </div>
</div>
@endsection
