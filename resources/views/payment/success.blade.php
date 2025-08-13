@extends('layouts.app')

@section('title', '付款成功 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h1 class="h2 fw-bold text-success mb-3">付款成功！</h1>
                <p class="lead mb-4">您的訂單已成功建立，我們會盡快為您處理。</p>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">訂單資訊</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>訂單編號：</strong>{{ $order->order_no ?? 'TEST-ORDER' }}</p>
                                <p><strong>付款金額：</strong>NT$ {{ number_format($order->total_price ?? 0) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>租車日期：</strong>{{ $order->rent_date ?? '2025-08-14' }}</p>
                                <p><strong>還車日期：</strong>{{ $order->return_date ?? '2025-08-15' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <h6>重要提醒：</h6>
                    <ul class="mb-0 text-start">
                        <li>請在取車時攜帶身分證件和駕照</li>
                        <li>請準時歸還車輛</li>
                        <li>如有疑問請聯繫客服</li>
                    </ul>
                </div>
                
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">
                        <i class="bi bi-list"></i> 查看訂單
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        <i class="bi bi-house"></i> 返回首頁
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
