@extends('layouts.app')

@section('title', '導向付款頁面 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-credit-card display-1 text-primary"></i>
                    </div>
                    <h4>正在導向付款頁面</h4>
                    <p class="text-muted">請稍候，即將為您導向綠界金流付款頁面...</p>
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 自動提交表單到綠界金流 -->
<form id="ecpayForm" method="POST" action="{{ $ecpayParams['paymentUrl'] }}" style="display: none;">
    @foreach($ecpayParams['params'] as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 延遲 2 秒後自動提交表單
    setTimeout(function() {
        document.getElementById('ecpayForm').submit();
    }, 2000);
});
</script>
@endsection
