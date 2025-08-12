@extends('layouts.app')

@section('title', '聯絡我們 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="h2 fw-bold">聯絡我們</h1>
                <p class="text-muted">有任何問題或建議，歡迎與我們聯繫</p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-telephone display-4 text-primary mb-3"></i>
                            <h5>客服專線</h5>
                            <p class="text-muted">0800-123-456</p>
                            <p class="small text-muted">週一至週日 24小時服務</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-envelope display-4 text-primary mb-3"></i>
                            <h5>電子郵件</h5>
                            <p class="text-muted">info@rentbike.com</p>
                            <p class="small text-muted">我們會在24小時內回覆</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">聯絡表單</h5>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">姓名</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">電子郵件</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">主旨</label>
                            <input type="text" class="form-control" id="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">訊息內容</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> 送出訊息
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
