@extends('layouts.app')

@section('title', '商店列表 - 機車出租網站')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 fw-bold">商店列表</h1>
            <p class="text-muted">瀏覽所有服務據點</p>
        </div>
    </div>

    <!-- Stores Grid -->
    <div class="row">
        @forelse($stores as $store)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $store->name }}</h5>
                        
                        <div class="mb-3">
                            <p class="text-muted mb-1">
                                <i class="bi bi-geo-alt"></i> {{ $store->address }}
                            </p>
                            <p class="text-muted mb-1">
                                <i class="bi bi-telephone"></i> {{ $store->phone }}
                            </p>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $store->status == '啟用' ? 'success' : 'danger' }}">
                                {{ $store->status == '啟用' ? '營業中' : '停業中' }}
                            </span>
                            <a href="{{ route('stores.show', $store->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> 查看詳情
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-building display-1 text-muted"></i>
                    <h3 class="mt-3">目前沒有商店資訊</h3>
                    <p class="text-muted">請稍後再試</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($stores->hasPages())
        <div class="row">
            <div class="col-12">
                <nav aria-label="商店列表分頁">
                    {{ $stores->links() }}
                </nav>
            </div>
        </div>
    @endif
</div>
@endsection
