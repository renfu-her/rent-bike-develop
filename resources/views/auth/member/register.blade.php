@extends('layouts.app')

@section('title', '會員註冊 - 機車出租網站')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">會員註冊</h4>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('member.register') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">姓名 *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">電子郵件 *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">密碼 *</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required
                                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$"
                                        title="密碼必須包含至少8個字符，包括至少1個小寫英文字母、1個大寫英文字母和1個數字">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="password-requirements mt-2">
                                        <small class="text-muted">密碼要求：</small>
                                        <ul class="list-unstyled small mt-1">
                                            <li id="length-check" class="text-danger">
                                                <i class="bi bi-x-circle"></i> 至少8個字符
                                            </li>
                                            <li id="lowercase-check" class="text-danger">
                                                <i class="bi bi-x-circle"></i> 至少1個小寫英文字母
                                            </li>
                                            <li id="uppercase-check" class="text-danger">
                                                <i class="bi bi-x-circle"></i> 至少1個大寫英文字母
                                            </li>
                                            <li id="number-check" class="text-danger">
                                                <i class="bi bi-x-circle"></i> 至少1個數字
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">確認密碼 *</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="password-match mt-2">
                                        <small id="password-match-text" class="text-danger">
                                            <i class="bi bi-x-circle"></i> 密碼不匹配
                                        </small>
                                    </div>
                                    <div class="password-tips mt-2">
                                        <small class="text-muted">
                                            <i class="bi bi-lightbulb"></i> 密碼提示：
                                        </small>
                                        <ul class="list-unstyled small mt-1 text-muted">
                                            <li><i class="bi bi-dot"></i> 避免使用個人資訊（如生日、英文姓名）</li>
                                            <li><i class="bi bi-dot"></i> 密碼至少8個字符，包含至少1個小寫英文字母、1個大寫英文字母和1個數字</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="id_number" class="form-label">身份證字號 *</label>
                                    <input type="text" class="form-control @error('id_number') is-invalid @enderror"
                                        id="id_number" name="id_number" value="{{ old('id_number') }}" required>
                                    @error('id_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">電話 *</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">地址 *</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        我同意 <a href="#" target="_blank">服務條款</a> 和 <a href="#"
                                            target="_blank">隱私政策</a>
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-person-plus"></i> 註冊
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0">已有帳號？</p>
                            <a href="{{ route('member.login') }}" class="btn btn-outline-primary">
                                <i class="bi bi-box-arrow-in-right"></i> 立即登入
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // 確保 jQuery 已載入
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
        } else {
            $(document).ready(function() {
                const $passwordInput = $('#password');
                const $confirmPasswordInput = $('#password_confirmation');
                const $termsCheckbox = $('#terms');
                const $form = $('form');

                // Password validation elements
                const $lengthCheck = $('#length-check');
                const $lowercaseCheck = $('#lowercase-check');
                const $uppercaseCheck = $('#uppercase-check');
                const $numberCheck = $('#number-check');
                const $passwordMatchText = $('#password-match-text');

                // Password validation function
                function validatePassword(password) {
                    const hasLength = password.length >= 8;
                    const hasLowercase = /[a-z]/.test(password);
                    const hasUppercase = /[A-Z]/.test(password);
                    const hasNumber = /\d/.test(password);

                    // Update visual feedback
                    updateRequirement($lengthCheck, hasLength);
                    updateRequirement($lowercaseCheck, hasLowercase);
                    updateRequirement($uppercaseCheck, hasUppercase);
                    updateRequirement($numberCheck, hasNumber);

                    return hasLength && hasLowercase && hasUppercase && hasNumber;
                }

                // Update requirement visual feedback
                function updateRequirement($element, isValid) {
                    const $icon = $element.find('i');
                    if (isValid) {
                        $element.removeClass('text-danger').addClass('text-success');
                        $icon.removeClass('bi-x-circle').addClass('bi-check-circle');
                    } else {
                        $element.removeClass('text-success').addClass('text-danger');
                        $icon.removeClass('bi-check-circle').addClass('bi-x-circle');
                    }
                }

                // Password confirmation validation
                function validatePasswordConfirmation() {
                    const password = $passwordInput.val();
                    const confirmPassword = $confirmPasswordInput.val();
                    const isValid = password === confirmPassword && password !== '';

                    if (confirmPassword !== '') {
                        if (isValid) {
                            $passwordMatchText.removeClass('text-danger').addClass('text-success');
                            $passwordMatchText.html('<i class="bi bi-check-circle"></i> 密碼匹配');
                        } else {
                            $passwordMatchText.removeClass('text-success').addClass('text-danger');
                            $passwordMatchText.html('<i class="bi bi-x-circle"></i> 密碼不匹配');
                        }
                    } else {
                        $passwordMatchText.removeClass('text-success').addClass('text-danger');
                        $passwordMatchText.html('<i class="bi bi-x-circle"></i> 密碼不匹配');
                    }

                    return isValid;
                }

                // Event listeners
                $passwordInput.on('input', function() {
                    validatePassword($(this).val());
                    if ($confirmPasswordInput.val()) {
                        validatePasswordConfirmation();
                    }
                });

                $confirmPasswordInput.on('input', validatePasswordConfirmation);

                // Terms checkbox validation
                $termsCheckbox.removeAttr('required');

                // Create error message element for terms
                const $termsErrorElement = $('<div class="alert alert-danger mt-2 d-none">' +
                    '<i class="bi bi-exclamation-triangle"></i> 請同意服務條款和隱私政策才能繼續</div>');
                $termsCheckbox.parent().append($termsErrorElement);

                // Form submission validation
                $form.on('submit', function(e) {
                    const isPasswordValid = validatePassword($passwordInput.val());
                    const isPasswordMatch = validatePasswordConfirmation();
                    const isTermsAccepted = $termsCheckbox.is(':checked');

                    if (!isPasswordValid) {
                        e.preventDefault();
                        alert('請確保密碼符合所有要求');
                        $passwordInput.focus();
                        return false;
                    }

                    if (!isPasswordMatch) {
                        e.preventDefault();
                        alert('請確認密碼輸入正確');
                        $confirmPasswordInput.focus();
                        return false;
                    }

                    if (!isTermsAccepted) {
                        e.preventDefault();
                        $termsErrorElement.removeClass('d-none');
                        $termsCheckbox.focus();
                        return false;
                    } else {
                        $termsErrorElement.addClass('d-none');
                    }
                });

                // Hide terms error when checkbox is checked
                $termsCheckbox.on('change', function() {
                    if ($(this).is(':checked')) {
                        $termsErrorElement.addClass('d-none');
                    }
                });
            });
        }
    </script>
@endpush
