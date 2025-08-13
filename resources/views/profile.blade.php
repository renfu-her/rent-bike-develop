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

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> 請檢查以下錯誤：
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">會員資訊</h5>
                        <button class="btn btn-light btn-sm" onclick="toggleEdit()">
                            <i class="bi bi-pencil"></i> 編輯資料
                        </button>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label"><strong>姓名</strong></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label"><strong>電子郵件</strong></label>
                                        <input type="email" class="form-control" id="email" value="{{ $member->email }}" readonly disabled>
                                        <small class="text-muted">電子郵件不可修改</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_number" class="form-label"><strong>身份證字號</strong></label>
                                        <input type="text" class="form-control" id="id_number" name="id_number" value="{{ $member->id_number }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label"><strong>電話</strong></label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $member->phone }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="license_plate" class="form-label"><strong>駕照號碼</strong></label>
                                        <input type="text" class="form-control" id="license_plate" value="{{ $member->license_plate ?? '尚未填寫' }}" readonly disabled>
                                        <small class="text-muted">駕照號碼會在首次租車時自動填入</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label"><strong>地址</strong></label>
                                        <textarea class="form-control" id="address" name="address" rows="3" readonly>{{ $member->address }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><strong>註冊時間</strong></label>
                                        <input type="text" class="form-control" value="{{ $member->created_at->format('Y-m-d H:i:s') }}" readonly disabled>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="saveBtn" style="display: none;">
                                    <i class="bi bi-check-circle"></i> 儲存變更
                                </button>
                                <button type="button" class="btn btn-secondary" id="cancelBtn" style="display: none;" onclick="cancelEdit()">
                                    <i class="bi bi-x-circle"></i> 取消編輯
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-house"></i> 返回首頁
                                </a>
                            </div>
                        </form>
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

<script>
function toggleEdit() {
    const inputs = document.querySelectorAll('#name, #id_number, #phone, #address');
    const saveBtn = document.getElementById('saveBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const editBtn = document.querySelector('.btn-light');
    
    inputs.forEach(input => {
        input.readOnly = !input.readOnly;
        if (!input.readOnly) {
            input.classList.add('border-primary');
        } else {
            input.classList.remove('border-primary');
        }
    });
    
    if (saveBtn.style.display === 'none') {
        saveBtn.style.display = 'inline-block';
        cancelBtn.style.display = 'inline-block';
        editBtn.innerHTML = '<i class="bi bi-eye"></i> 檢視模式';
        editBtn.classList.remove('btn-light');
        editBtn.classList.add('btn-outline-light');
    } else {
        saveBtn.style.display = 'none';
        cancelBtn.style.display = 'none';
        editBtn.innerHTML = '<i class="bi bi-pencil"></i> 編輯資料';
        editBtn.classList.remove('btn-outline-light');
        editBtn.classList.add('btn-light');
    }
}

function cancelEdit() {
    const inputs = document.querySelectorAll('#name, #id_number, #phone, #address');
    const saveBtn = document.getElementById('saveBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const editBtn = document.querySelector('.btn-outline-light');
    
    inputs.forEach(input => {
        input.readOnly = true;
        input.classList.remove('border-primary');
    });
    
    saveBtn.style.display = 'none';
    cancelBtn.style.display = 'none';
    editBtn.innerHTML = '<i class="bi bi-pencil"></i> 編輯資料';
    editBtn.classList.remove('btn-outline-light');
    editBtn.classList.add('btn-light');
}
</script>
@endsection
