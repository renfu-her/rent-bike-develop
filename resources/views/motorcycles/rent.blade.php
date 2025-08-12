@extends('layouts.app')

@section('title', '預約 ' . $motorcycle->name . ' - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('motorcycles.index') }}">機車列表</a></li>
                    <li class="breadcrumb-item active">預約 {{ $motorcycle->name }}</li>
                </ol>
            </nav>

            <!-- Motorcycle Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="h3 fw-bold">{{ $motorcycle->name }}</h2>
                            <p class="text-muted mb-2">
                                <i class="bi bi-tag"></i> {{ $motorcycle->model }}
                            </p>
                            <p class="text-muted mb-2">
                                <i class="bi bi-123"></i> {{ $motorcycle->license_plate }}
                            </p>
                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt"></i> {{ $motorcycle->store->name }}
                            </p>
                            <div class="h4 text-primary fw-bold">
                                NT$ {{ number_format($motorcycle->price) }} / 天
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <span class="badge bg-success fs-6">可預約</span>
                        </div>
                    </div>

                    @if($motorcycle->accessories)
                        <hr>
                        <h6>包含配件：</h6>
                        <div class="row">
                            @foreach($motorcycle->accessories as $accessoryId)
                                @php
                                    $accessory = \App\Models\MotorcycleAccessory::find($accessoryId);
                                @endphp
                                @if($accessory)
                                    <div class="col-md-6">
                                        <i class="bi bi-check-circle text-success"></i> {{ $accessory->model }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Rental Form -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">預約資訊</h4>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">姓名 *</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">電話 *</label>
                                <input type="tel" class="form-control" id="phone" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_number" class="form-label">身份證字號 *</label>
                                <input type="text" class="form-control" id="id_number" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="license_number" class="form-label">駕照號碼 *</label>
                                <input type="text" class="form-control" id="license_number" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">地址 *</label>
                            <textarea class="form-control" id="address" rows="2" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rent_date" class="form-label">租車日期 *</label>
                                <input type="date" class="form-control" id="rent_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="return_date" class="form-label">還車日期 *</label>
                                <input type="date" class="form-control" id="return_date" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">備註</label>
                            <textarea class="form-control" id="notes" rows="3" placeholder="如有特殊需求請在此說明"></textarea>
                        </div>

                        <hr>

                        <!-- Terms and Conditions -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    我已閱讀並同意 <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">租車條款</a>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('motorcycles.index') }}" class="btn btn-outline-secondary me-md-2">取消</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> 確認預約
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    $('#rent_date').attr('min', today);
    $('#return_date').attr('min', today);

    // Update return date minimum when rent date changes
    $('#rent_date').change(function() {
        $('#return_date').attr('min', $(this).val());
    });
});
</script>
@endpush
