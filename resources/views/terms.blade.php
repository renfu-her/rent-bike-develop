@extends('layouts.app')

@section('title', '服務條款 - 機車出租網站')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-file-text"></i> 服務條款
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <p class="text-muted">最後更新日期：{{ date('Y年m月d日') }}</p>
                    </div>

                    <h5 class="text-primary">一、服務說明</h5>
                    <p>歡迎使用機車出租網站服務。本網站提供機車租賃服務，讓您能夠方便地租用機車進行短程或長程旅行。</p>

                    <h5 class="text-primary mt-4">二、租車資格</h5>
                    <ul>
                        <li>年滿18歲且有有效機車駕照</li>
                        <li>需攜帶身分證件正本（身分證或護照）</li>
                        <li>需提供有效聯絡方式（手機號碼）</li>
                        <li>需有良好的駕駛記錄</li>
                        <li>外國旅客需提供國際駕照及護照</li>
                    </ul>

                    <h5 class="text-primary mt-4">三、租車程序</h5>
                    <ol>
                        <li>線上預約：選擇機車、租期並完成預約</li>
                        <li>身份驗證：取車時需出示身分證件及駕照</li>
                        <li>車輛檢查：取車前雙方共同檢查車輛狀況</li>
                        <li>簽署合約：確認租車條款並簽署租車合約</li>
                        <li>繳納費用：支付租金及押金</li>
                    </ol>

                    <h5 class="text-primary mt-4">四、租車費用</h5>
                    <ul>
                        <li>租金以天數計算，不足一天以一天計費</li>
                        <li>需繳納押金，金額依車型而定</li>
                        <li>超時費用：每小時加收原日租金的1/24</li>
                        <li>油費：還車時需加滿油，或支付油費差額</li>
                        <li>清潔費：車輛髒污嚴重時需支付清潔費</li>
                    </ul>

                    <h5 class="text-primary mt-4">五、使用規定</h5>
                    <ul>
                        <li>請遵守交通規則及相關法規</li>
                        <li>不得轉借他人使用</li>
                        <li>不得從事非法活動</li>
                        <li>不得超載或載運危險物品</li>
                        <li>不得在禁止區域行駛</li>
                        <li>請愛護車輛，保持車況良好</li>
                    </ul>

                    <h5 class="text-primary mt-4">六、保險與責任</h5>
                    <ul>
                        <li>本公司提供基本保險，包含強制險</li>
                        <li>建議加保第三人責任險及車體險</li>
                        <li>因駕駛人過失造成的事故，需負擔相關責任</li>
                        <li>酒駕、無照駕駛等違法行為不在保險範圍內</li>
                    </ul>

                    <h5 class="text-primary mt-4">七、車輛損壞與維修</h5>
                    <ul>
                        <li>正常使用磨損不計費用</li>
                        <li>人為損壞需負擔維修費用</li>
                        <li>重大事故需負擔相關法律責任</li>
                        <li>維修期間無法使用車輛，租金不予退還</li>
                    </ul>

                    <h5 class="text-primary mt-4">八、還車規定</h5>
                    <ul>
                        <li>請準時歸還車輛</li>
                        <li>還車地點為原取車地點</li>
                        <li>還車時需加滿油</li>
                        <li>車輛需保持清潔</li>
                        <li>雙方共同檢查車輛狀況</li>
                    </ul>

                    <h5 class="text-primary mt-4">九、取消政策</h5>
                    <ul>
                        <li>預約前24小時可免費取消</li>
                        <li>24小時內取消需收取手續費（租金10%）</li>
                        <li>取車前2小時內取消需收取手續費（租金20%）</li>
                        <li>天災等不可抗力因素可免費取消</li>
                    </ul>

                    <h5 class="text-primary mt-4">十、違約處理</h5>
                    <ul>
                        <li>逾期未還：每日加收原日租金200%</li>
                        <li>違規使用：立即終止合約並沒收押金</li>
                        <li>車輛損壞：需負擔維修費用及營業損失</li>
                        <li>違法行為：移送相關機關處理</li>
                    </ul>

                    <h5 class="text-primary mt-4">十一、爭議處理</h5>
                    <p>如有爭議，雙方應先進行協商。協商不成時，得依中華民國法律及相關法規處理。</p>

                    <h5 class="text-primary mt-4">十二、條款修改</h5>
                    <p>本公司保留修改本服務條款的權利，修改後將於網站公告，繼續使用服務即表示同意修改內容。</p>

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
