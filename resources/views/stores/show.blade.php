@extends('layouts.app')

@section('title', $store->name . ' - 機車出租網站')

@section('content')
<div class="container">
    <!-- Store Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('stores.index') }}">商店列表</a></li>
                    <li class="breadcrumb-item active">{{ $store->name }}</li>
                </ol>
            </nav>
            
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="h2 fw-bold">{{ $store->name }}</h1>
                            <p class="text-muted mb-3">
                                <i class="bi bi-geo-alt"></i> {{ $store->address }}
                            </p>
                            <p class="text-muted mb-3">
                                <i class="bi bi-telephone"></i> {{ $store->phone }}
                            </p>
                            <span class="badge bg-success">營業中</span>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="{{ route('motorcycles.index') }}?store={{ $store->id }}" class="btn btn-primary">
                                <i class="bi bi-search"></i> 查看機車
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Store Motorcycles -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="h4 fw-bold mb-3">本店機車</h3>
        </div>
    </div>

    <div class="row">
        @forelse($store->motorcycles as $motorcycle)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $motorcycle->name }}</h5>
                                                         <span class="badge bg-{{ $motorcycle->status == '可出租' ? 'success' : ($motorcycle->status == '已出租' ? 'warning' : 'danger') }}">
                                {{ $motorcycle->status_text }}
                            </span>
                        </div>
                        
                        <p class="text-muted mb-2">
                            <i class="bi bi-tag"></i> {{ $motorcycle->model }}
                        </p>
                        
                        <p class="text-muted mb-2">
                            <i class="bi bi-123"></i> {{ $motorcycle->license_plate }}
                        </p>
                        
                        @if($motorcycle->accessories)
                            <div class="mb-3">
                                <small class="text-muted">配件：</small>
                                <div class="mt-1">
                                    @foreach($motorcycle->accessories as $accessoryId)
                                        @php
                                            $accessory = \App\Models\MotorcycleAccessory::find($accessoryId);
                                        @endphp
                                        @if($accessory)
                                            <span class="badge bg-light text-dark me-1">{{ $accessory->model }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="h5 text-primary mb-0">
                                NT$ {{ number_format($motorcycle->price) }}
                            </div>
                            <div class="btn-group">
                                                                 @if($motorcycle->status == '可出租')
                                    <a href="{{ route('motorcycles.rent', $motorcycle->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-cart-plus"></i> 預約
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="bi bi-x-circle"></i> 無法預約
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-truck display-1 text-muted"></i>
                    <h3 class="mt-3">此商店目前沒有機車</h3>
                    <p class="text-muted">請稍後再試或查看其他商店</p>
                    <a href="{{ route('stores.index') }}" class="btn btn-primary">查看其他商店</a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Store Information -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">商店資訊</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>營業時間</h6>
                            <p class="text-muted">週一至週日 24小時營業</p>
                            
                            <h6>服務項目</h6>
                            <ul class="text-muted">
                                <li>機車出租</li>
                                <li>配件租借</li>
                                <li>道路救援</li>
                                <li>維修保養</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>付款方式</h6>
                            <ul class="text-muted">
                                <li>現金</li>
                                <li>信用卡</li>
                                <li>行動支付</li>
                            </ul>
                            
                            <h6>注意事項</h6>
                            <ul class="text-muted">
                                <li>請攜帶有效身分證件</li>
                                <li>需年滿18歲且有駕照</li>
                                <li>請遵守交通規則</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
