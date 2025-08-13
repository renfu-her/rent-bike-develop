@extends('layouts.app')

@section('title', '付款失敗 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-x-circle text-danger" style="font-size: 4rem;"></i>
                </div>
                <h1 class="h2 fw-bold text-danger mb-3">付款失敗</h1>
                <p class="lead mb-4">很抱歉，您的付款未能成功完成。</p>
                
                @if($order)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">訂單資訊</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>訂單編號：</strong>{{ $order->order_no }}</p>
                                <p><strong>付款金額：</strong>NT$ {{ number_format($order->total_price) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>租車日期：</strong>{{ $order->rent_date }}</p>
                                <p><strong>還車日期：</strong>{{ $order->return_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="alert alert-warning">
                    <h6>可能的失敗原因：</h6>
                    <ul class="mb-0 text-start">
                        <li>信用卡資訊輸入錯誤</li>
                        <li>信用卡餘額不足</li>
                        <li>銀行拒絕交易</li>
                        <li>網路連線問題</li>
                    </ul>
                </div>
                
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('cart.checkout') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-clockwise"></i> 重新付款
                    </a>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-list"></i> 查看訂單
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-house"></i> 返回首頁
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
