@extends('layouts.app')

@section('title', '我的訂單 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="h2 fw-bold">我的訂單</h1>
                <p class="text-muted">此功能正在開發中</p>
            </div>
            
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-receipt display-1 text-muted mb-3"></i>
                    <h5>功能開發中</h5>
                    <p class="text-muted">訂單管理功能正在開發中，敬請期待！</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">返回首頁</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
