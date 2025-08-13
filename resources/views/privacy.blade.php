@extends('layouts.app')

@section('title', '隱私政策 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-shield-check"></i> 隱私政策
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <p class="text-muted">最後更新日期：{{ date('Y年m月d日') }}</p>
                    </div>

                    <h5 class="text-primary">一、隱私政策概述</h5>
                    <p>機車出租網站（以下簡稱「本網站」）非常重視您的隱私權保護。本隱私政策說明我們如何收集、使用、儲存和保護您的個人資料。</p>

                    <h5 class="text-primary mt-4">二、個人資料收集</h5>
                    <h6 class="fw-bold">2.1 註冊資料</h6>
                    <ul>
                        <li>姓名</li>
                        <li>電子郵件地址</li>
                        <li>手機號碼</li>
                        <li>身分證字號</li>
                        <li>地址</li>
                        <li>駕照資訊</li>
                    </ul>

                    <h6 class="fw-bold mt-3">2.2 租車相關資料</h6>
                    <ul>
                        <li>租車記錄</li>
                        <li>付款資訊</li>
                        <li>車輛使用狀況</li>
                        <li>事故記錄（如有）</li>
                    </ul>

                    <h6 class="fw-bold mt-3">2.3 網站使用資料</h6>
                    <ul>
                        <li>IP位址</li>
                        <li>瀏覽器類型</li>
                        <li>訪問時間</li>
                        <li>頁面瀏覽記錄</li>
                        <li>Cookie資料</li>
                    </ul>

                    <h5 class="text-primary mt-4">三、個人資料使用目的</h5>
                    <ul>
                        <li>提供機車租賃服務</li>
                        <li>身份驗證及安全檢查</li>
                        <li>處理付款及帳務</li>
                        <li>客戶服務及支援</li>
                        <li>法律合規要求</li>
                        <li>服務改善及分析</li>
                        <li>行銷推廣（需經您同意）</li>
                    </ul>

                    <h5 class="text-primary mt-4">四、個人資料保護措施</h5>
                    <h6 class="fw-bold">4.1 技術保護</h6>
                    <ul>
                        <li>使用SSL加密技術保護資料傳輸</li>
                        <li>資料庫加密儲存</li>
                        <li>定期安全更新及漏洞修補</li>
                        <li>防火牆及入侵偵測系統</li>
                    </ul>

                    <h6 class="fw-bold mt-3">4.2 管理保護</h6>
                    <ul>
                        <li>員工隱私權教育訓練</li>
                        <li>資料存取權限控制</li>
                        <li>定期安全稽核</li>
                        <li>資料備份及災難復原</li>
                    </ul>

                    <h5 class="text-primary mt-4">五、個人資料分享</h5>
                    <p>除以下情況外，我們不會與第三方分享您的個人資料：</p>
                    <ul>
                        <li>經您明確同意</li>
                        <li>法律要求或政府機關要求</li>
                        <li>保護本網站及用戶權益</li>
                        <li>與服務提供者合作（如付款處理、保險公司）</li>
                        <li>企業合併、收購或資產轉讓</li>
                    </ul>

                    <h5 class="text-primary mt-4">六、Cookie使用政策</h5>
                    <p>本網站使用Cookie來改善用戶體驗：</p>
                    <ul>
                        <li><strong>必要Cookie：</strong>維持網站基本功能</li>
                        <li><strong>功能Cookie：</strong>記住您的偏好設定</li>
                        <li><strong>分析Cookie：</strong>了解網站使用情況</li>
                        <li><strong>行銷Cookie：</strong>提供個人化廣告（需同意）</li>
                    </ul>

                    <h5 class="text-primary mt-4">七、您的權利</h5>
                    <p>根據個人資料保護法，您享有以下權利：</p>
                    <ul>
                        <li><strong>查詢權：</strong>查詢您的個人資料</li>
                        <li><strong>閱覽權：</strong>閱覽您的個人資料</li>
                        <li><strong>製給複製本權：</strong>要求提供個人資料複製本</li>
                        <li><strong>補充或更正權：</strong>要求補充或更正個人資料</li>
                        <li><strong>停止處理權：</strong>要求停止處理個人資料</li>
                        <li><strong>刪除權：</strong>要求刪除個人資料</li>
                    </ul>

                    <h5 class="text-primary mt-4">八、資料保留期間</h5>
                    <ul>
                        <li>會員資料：至您要求刪除帳戶為止</li>
                        <li>租車記錄：依法律規定保留7年</li>
                        <li>付款記錄：依稅法規定保留7年</li>
                        <li>網站使用記錄：保留2年</li>
                    </ul>

                    <h5 class="text-primary mt-4">九、兒童隱私保護</h5>
                    <p>本網站不故意收集13歲以下兒童的個人資料。如發現誤收兒童資料，將立即刪除。</p>

                    <h5 class="text-primary mt-4">十、國際資料傳輸</h5>
                    <p>如需要將您的資料傳輸至國外，我們將確保：</p>
                    <ul>
                        <li>符合當地法律要求</li>
                        <li>提供適當的保護措施</li>
                        <li>事先告知並取得同意</li>
                    </ul>

                    <h5 class="text-primary mt-4">十一、隱私政策更新</h5>
                    <p>我們可能會更新本隱私政策。重大變更時，我們將：</p>
                    <ul>
                        <li>在網站上公告</li>
                        <li>發送電子郵件通知</li>
                        <li>在登入時提醒您</li>
                    </ul>

                    <h5 class="text-primary mt-4">十二、聯絡我們</h5>
                    <p>如對本隱私政策有任何疑問，請聯絡我們：</p>
                    <ul>
                        <li>電子郵件：privacy@rentbike.com</li>
                        <li>電話：0800-123-456</li>
                        <li>地址：[公司地址]</li>
                    </ul>

                    <div class="text-center mt-5">
                        <a href="{{ route('member.register') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> 返回註冊
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-house"></i> 返回首頁
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
