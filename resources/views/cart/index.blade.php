@extends('layouts.app')

@section('title', '購物車 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 fw-bold">
                    <i class="bi bi-cart3"></i> 購物車
                </h1>
                <a href="{{ route('motorcycles.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-plus-circle"></i> 繼續購物
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($cart->isEmpty())
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                        <h4>購物車是空的</h4>
                        <p class="text-muted">您還沒有添加任何機車到購物車</p>
                        <a href="{{ route('motorcycles.index') }}" class="btn btn-primary">
                            <i class="bi bi-bicycle"></i> 瀏覽機車
                        </a>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-0">購物車項目 ({{ $cart->getItemCount() }})</h5>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <form method="POST" action="{{ route('cart.clear') }}" class="d-inline" onsubmit="return confirm('確定要清空購物車嗎？')">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> 清空購物車
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($cartDetails as $item)
                            <div class="row align-items-center border-bottom py-3">
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light rounded p-2" style="width: 60px; height: 60px;">
                                                <i class="bi bi-bicycle fs-2 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ $item->motorcycle->name }}</h6>
                                            <small class="text-muted">{{ $item->motorcycle->model }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <div class="fw-bold">NT$ {{ number_format($item->unit_price) }}</div>
                                        <small class="text-muted">/ 天</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <div class="fw-bold">{{ $item->rent_date->format('m/d') }} - {{ $item->return_date->format('m/d') }}</div>
                                        <small class="text-muted">{{ $item->rent_date->diffInDays($item->return_date) + 1 }} 天</small>
                                        @if($item->license_plate)
                                            <div class="mt-1">
                                                <small class="text-muted">駕照：{{ $item->license_plate }}</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="text-end">
                                        <div class="fw-bold text-primary">NT$ {{ number_format($item->subtotal) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="text-end">
                                        <form method="POST" action="{{ route('cart.remove', $item->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('確定要移除這個項目嗎？')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i>
                                    <strong>注意：</strong> 購物車中的機車會在結帳時進行最終確認，實際可用性以結帳時為準。
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>總計：</span>
                                            <span class="fw-bold fs-5 text-primary">NT$ {{ number_format($cart->total_amount) }}</span>
                                        </div>
                                        <div class="d-grid">
                                            @auth('member')
                                                <a href="{{ route('cart.checkout') }}" class="btn btn-primary">
                                                    <i class="bi bi-credit-card"></i> 前往結帳
                                                </a>
                                            @else
                                                <a href="{{ route('member.login') }}" class="btn btn-primary">
                                                    <i class="bi bi-person"></i> 登入後結帳
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
