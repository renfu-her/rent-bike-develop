@extends('layouts.app')

@section('title', '我的訂單 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="h2 fw-bold">我的訂單</h1>
                <p class="text-muted">查看您的租車訂單記錄</p>
            </div>
            
            @auth('member')
                @php
                    $member = Auth::guard('member')->user();
                    $orders = $member->orders()->with(['store', 'orderDetails.motorcycle'])->orderBy('created_at', 'desc')->get();
                @endphp
                
                @if($orders->count() > 0)
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">訂單列表</h5>
                        </div>
                        <div class="card-body">
                            @foreach($orders as $order)
                                <div class="border rounded p-3 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <h6 class="mb-1">訂單編號</h6>
                                            <p class="text-muted mb-0">#{{ $order->id }}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <h6 class="mb-1">商店</h6>
                                            <p class="text-muted mb-0">{{ $order->store->name }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <h6 class="mb-1">租車日期</h6>
                                            <p class="text-muted mb-0">{{ $order->rent_date }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <h6 class="mb-1">總價</h6>
                                            <p class="text-primary fw-bold mb-0">NT$ {{ number_format($order->total_price) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <h6 class="mb-1">狀態</h6>
                                            <span class="badge bg-{{ $order->is_completed ? 'success' : 'warning' }}">
                                                {{ $order->is_completed ? '已完成' : '處理中' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if($order->orderDetails->count() > 0)
                                        <hr class="my-3">
                                        <h6>租車明細：</h6>
                                        <div class="row">
                                            @foreach($order->orderDetails as $detail)
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-between">
                                                        <span>{{ $detail->motorcycle->name }}</span>
                                                        <span class="text-muted">NT$ {{ number_format($detail->total) }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="bi bi-receipt display-1 text-muted mb-3"></i>
                            <h5>尚無訂單</h5>
                            <p class="text-muted">您還沒有任何租車訂單</p>
                            <a href="{{ route('motorcycles.index') }}" class="btn btn-primary">立即租車</a>
                        </div>
                    </div>
                @endif
            @else
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-exclamation-triangle display-1 text-warning mb-3"></i>
                        <h5>請先登入</h5>
                        <p class="text-muted">您需要登入才能查看訂單</p>
                        <a href="{{ route('member.login') }}" class="btn btn-primary">立即登入</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
