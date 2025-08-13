@extends('layouts.app')

@section('title', '結帳 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">首頁</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">購物車</a></li>
                        <li class="breadcrumb-item active">結帳</li>
                    </ol>
                </nav>
                <h1 class="h2 fw-bold">
                    <i class="bi bi-credit-card"></i> 結帳
                </h1>
            </div>

            <!-- 訂單摘要 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">訂單摘要</h5>
                </div>
                <div class="card-body">
                    @foreach($cartDetails as $item)
                        <div class="row align-items-center border-bottom py-3">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light rounded p-2" style="width: 50px; height: 50px;">
                                            <i class="bi bi-bicycle fs-4 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-1">{{ $item->motorcycle->name }}</h6>
                                        <small class="text-muted">{{ $item->motorcycle->model }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <small class="text-muted">租期</small>
                                    <div class="fw-bold">{{ $item->rent_date->format('m/d') }} - {{ $item->return_date->format('m/d') }}</div>
                                    @if($item->license_plate)
                                        <small class="text-muted">駕照：{{ $item->license_plate }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="text-center">
                                    <small class="text-muted">單價</small>
                                    <div class="fw-bold">NT$ {{ number_format($item->unit_price) }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-end">
                                    <small class="text-muted">小計</small>
                                    <div class="fw-bold text-primary">NT$ {{ number_format($item->subtotal) }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>重要提醒：</strong>
                                <ul class="mb-0 mt-2">
                                    <li>請確認租車日期和數量無誤</li>
                                    <li>取車時請攜帶身分證件和駕照</li>
                                    <li>如有疑問請聯繫客服</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>總計：</span>
                                        <span class="fw-bold fs-5 text-primary">NT$ {{ number_format($cart->total_amount) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 付款資訊 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">付款資訊</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('payment.process') }}" id="paymentForm">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                        
                        <div class="row">
                            <!-- 會員資訊 -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">會員資訊</label>
                                <div class="form-control-plaintext">
                                    <div><strong>{{ auth('member')->user()->name }}</strong></div>
                                    <div class="text-muted">{{ auth('member')->user()->email }}</div>
                                    <div class="text-muted">{{ auth('member')->user()->phone }}</div>
                                </div>
                            </div>

                            <!-- 付款方式 -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">付款方式</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                                    <label class="form-check-label" for="credit_card">
                                        <i class="bi bi-credit-card"></i> 信用卡付款
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="atm" value="atm">
                                    <label class="form-check-label" for="atm">
                                        <i class="bi bi-bank"></i> ATM 轉帳
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- 發票資訊 -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">發票資訊</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="invoice_type" id="personal" value="personal" checked>
                                    <label class="form-check-label" for="personal">
                                        個人發票
                                    </label>
                                </div>
                                {{-- <div class="form-check">
                                    <input class="form-check-input" type="radio" name="invoice_type" id="company" value="company">
                                    <label class="form-check-label" for="company">
                                        公司發票
                                    </label>
                                </div> --}}
                            </div>

                            <!-- 同意條款 -->
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agree_terms" required>
                                    <label class="form-check-label" for="agree_terms">
                                        我已閱讀並同意 <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">租車條款</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- 結帳按鈕 -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-lock"></i> 安全結帳 NT$ {{ number_format($cart->total_amount) }}
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-shield-check"></i> 您的付款資訊將透過綠界金流安全加密處理
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 條款 Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">租車條款</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>租車資格</h6>
                <ul>
                    <li>年滿18歲且有有效駕照</li>
                    <li>需攜帶身分證件正本</li>
                    <li>需提供有效聯絡方式</li>
                </ul>

                <h6>租車費用</h6>
                <ul>
                    <li>租金以天數計算</li>
                    <li>需繳納押金</li>
                    <li>超時費用另計</li>
                </ul>

                <h6>注意事項</h6>
                <ul>
                    <li>請遵守交通規則</li>
                    <li>不得轉借他人使用</li>
                    <li>如有損壞需負擔維修費用</li>
                    <li>請準時歸還車輛</li>
                </ul>

                <h6>取消政策</h6>
                <ul>
                    <li>預約前24小時可免費取消</li>
                    <li>24小時內取消需收取手續費</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const agreeCheckbox = document.getElementById('agree_terms');
    
    // 移除原有的 required 屬性，改用自定義驗證
    agreeCheckbox.removeAttribute('required');
    
    // 創建錯誤訊息元素
    let errorElement = document.createElement('div');
    errorElement.className = 'alert alert-danger mt-2 d-none';
    errorElement.innerHTML = '<i class="bi bi-exclamation-triangle"></i> 請勾選同意條款才能繼續';
    agreeCheckbox.parentNode.appendChild(errorElement);
    
    // 表單提交驗證
    form.addEventListener('submit', function(e) {
        if (!agreeCheckbox.checked) {
            e.preventDefault();
            errorElement.classList.remove('d-none');
            agreeCheckbox.focus();
            return false;
        } else {
            errorElement.classList.add('d-none');
        }
    });
    
    // 當用戶勾選時隱藏錯誤訊息
    agreeCheckbox.addEventListener('change', function() {
        if (this.checked) {
            errorElement.classList.add('d-none');
        }
    });
});
</script>
@endsection
