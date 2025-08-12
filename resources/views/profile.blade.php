@extends('layouts.app')

@section('title', '個人資料 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="h2 fw-bold">個人資料</h1>
                <p class="text-muted">管理您的會員資訊</p>
            </div>
            
            @auth('member')
                @php
                    $member = Auth::guard('member')->user();
                @endphp
                
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">會員資訊</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>姓名：</strong>{{ $member->name }}</p>
                                <p><strong>電子郵件：</strong>{{ $member->email }}</p>
                                <p><strong>身份證字號：</strong>{{ $member->id_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>電話：</strong>{{ $member->phone }}</p>
                                <p><strong>地址：</strong>{{ $member->address }}</p>
                                <p><strong>註冊時間：</strong>{{ $member->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="text-center">
                            <a href="{{ route('home') }}" class="btn btn-primary">返回首頁</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-exclamation-triangle display-1 text-warning mb-3"></i>
                        <h5>請先登入</h5>
                        <p class="text-muted">您需要登入才能查看個人資料</p>
                        <a href="{{ route('member.login') }}" class="btn btn-primary">立即登入</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
