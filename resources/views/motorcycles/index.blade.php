@extends('layouts.app')

@section('title', '機車列表 - 機車出租網站')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 fw-bold">機車列表</h1>
            <p class="text-muted">瀏覽所有可出租的機車</p>
        </div>
    </div>



    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('motorcycles.index') }}" id="searchForm">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">搜尋機車</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="搜尋機車名稱或型號...">
                            </div>
                            <div class="col-md-3">
                                <label for="store" class="form-label">商店</label>
                                <select class="form-select" id="store" name="store">
                                    <option value="">所有商店</option>
                                    @if($stores->count() > 0)
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}" {{ request('store') == $store->id ? 'selected' : '' }}>
                                                {{ $store->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>沒有可用的商店</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">狀態</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">所有狀態</option>
                                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>可出租</option>
                                    <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>已出租</option>
                                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>維修中</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i> 搜尋
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Motorcycles Grid -->
    <div class="row" id="motorcyclesGrid">
        @forelse($motorcycles as $motorcycle)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $motorcycle->name }}</h5>
                                                               <span class="badge bg-{{ $motorcycle->status == 'available' ? 'primary' : ($motorcycle->status == 'rented' ? 'warning' : 'danger') }}">
                                {{ $motorcycle->status_text }}
                            </span>
                        </div>
                        
                        <p class="text-muted mb-2">
                            <i class="bi bi-tag"></i> {{ $motorcycle->model }}
                        </p>
                        
                        <p class="text-muted mb-2">
                            <i class="bi bi-geo-alt"></i> {{ $motorcycle->store->name }}
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
                                   <button type="button" class="btn btn-outline-primary btn-sm"
                                           data-bs-toggle="modal" data-bs-target="#motorcycleModal{{ $motorcycle->id }}">
                                       <i class="bi bi-eye"></i> 詳細
                                   </button>
                                   @if($motorcycle->status == 'available')
                                       <button type="button" class="btn btn-success btn-sm" 
                                               data-bs-toggle="modal" data-bs-target="#addToCartModal{{ $motorcycle->id }}">
                                           <i class="bi bi-cart-plus"></i> 加入購物車
                                       </button>
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

            <!-- Motorcycle Detail Modal -->
            <div class="modal fade" id="motorcycleModal{{ $motorcycle->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $motorcycle->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>基本資訊</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>型號：</strong>{{ $motorcycle->model }}</li>
                                        <li><strong>車牌：</strong>{{ $motorcycle->license_plate }}</li>
                                        <li><strong>商店：</strong>{{ $motorcycle->store->name }}</li>
                                        <li><strong>狀態：</strong>
                                            <span class="badge bg-{{ $motorcycle->status == 'available' ? 'primary' : ($motorcycle->status == 'rented' ? 'warning' : 'danger') }}">
                                                {{ $motorcycle->status_text }}
                                            </span>
                                        </li>
                                        <li><strong>價格：</strong>NT$ {{ number_format($motorcycle->price) }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>商店資訊</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>地址：</strong>{{ $motorcycle->store->address }}</li>
                                        <li><strong>電話：</strong>{{ $motorcycle->store->phone }}</li>
                                    </ul>
                                    
                                    @if($motorcycle->accessories)
                                        <h6 class="mt-3">配件</h6>
                                        <ul class="list-unstyled">
                                            @foreach($motorcycle->accessories as $accessoryId)
                                                @php
                                                    $accessory = \App\Models\MotorcycleAccessory::find($accessoryId);
                                                @endphp
                                                @if($accessory)
                                                    <li><i class="bi bi-check-circle text-success"></i> {{ $accessory->model }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                            @if($motorcycle->status == 'available')
                                <button type="button" class="btn btn-success" 
                                        data-bs-toggle="modal" data-bs-target="#addToCartModal{{ $motorcycle->id }}">
                                    <i class="bi bi-cart-plus"></i> 加入購物車
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add to Cart Modal -->
            <div class="modal fade" id="addToCartModal{{ $motorcycle->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">加入購物車 - {{ $motorcycle->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="{{ route('cart.add', $motorcycle->id) }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="rent_date_{{ $motorcycle->id }}" class="form-label">租車日期 *</label>
                                            <input type="date" class="form-control" id="rent_date_{{ $motorcycle->id }}" 
                                                   name="rent_date" required min="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="return_date_{{ $motorcycle->id }}" class="form-label">還車日期 *</label>
                                            <input type="date" class="form-control" id="return_date_{{ $motorcycle->id }}" 
                                                   name="return_date" required min="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="license_plate_{{ $motorcycle->id }}" class="form-label">駕照號碼 *</label>
                                    <input type="text" class="form-control" id="license_plate_{{ $motorcycle->id }}" 
                                           name="license_plate" required placeholder="請輸入您的駕照號碼"
                                           value="{{ auth('member')->check() ? auth('member')->user()->license_plate : '' }}">
                                    <small class="text-muted">此駕照號碼將保存到您的會員資料中</small>
                                </div>
                                <div class="mb-3">
                                    <label for="notes_{{ $motorcycle->id }}" class="form-label">備註</label>
                                    <textarea class="form-control" id="notes_{{ $motorcycle->id }}" 
                                              name="notes" rows="2" placeholder="如有特殊需求請在此說明"></textarea>
                                </div>
                                <div class="alert alert-info">
                                    <small>
                                        <i class="bi bi-info-circle"></i>
                                        <strong>價格：</strong>NT$ {{ number_format($motorcycle->price) }} / 天
                                    </small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cart-plus"></i> 加入購物車
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-search display-1 text-muted"></i>
                    <h3 class="mt-3">沒有找到符合條件的機車</h3>
                    <p class="text-muted">請嘗試調整搜尋條件</p>
                    <a href="{{ route('motorcycles.index') }}" class="btn btn-primary">清除篩選</a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($motorcycles->hasPages())
        <div class="row">
            <div class="col-12">
                <nav aria-label="機車列表分頁">
                    {{ $motorcycles->links() }}
                </nav>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit form when filters change
    $('#store, #status').change(function() {
        $('#searchForm').submit();
    });
    
    // Clear search when clicking clear button
    $('.btn-clear').click(function() {
        $('#search').val('');
        $('#store').val('');
        $('#status').val('');
        $('#searchForm').submit();
    });
});
</script>
@endpush
