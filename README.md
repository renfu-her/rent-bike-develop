# 機車出租網站 (Motorcycle Rental Website)

一個基於 Laravel 和 Filament 開發的現代化機車出租管理系統，提供完整的線上租車服務。

## 🚀 功能特色

### 前台功能
- **會員系統**：註冊、登入、個人資料管理
- **機車瀏覽**：查看可用機車、詳細資訊、價格
- **線上預約**：選擇租期、加入購物車、線上結帳
- **訂單管理**：查看租車記錄、訂單狀態
- **商店資訊**：查看各分店位置和聯絡資訊

### 後台管理 (Filament Admin)
- **機車管理**：新增、編輯、刪除機車資訊
- **商店管理**：管理各分店資訊
- **會員管理**：查看和管理會員資料
- **訂單管理**：查看所有租車訂單（唯讀模式）
- **訂單明細**：查看訂單詳細內容
- **儀表板**：統計圖表、即時數據

## 🛠 技術架構

### 後端技術
- **Laravel 12** - PHP 框架
- **Filament 3** - 後台管理面板
- **MySQL/SQLite** - 資料庫
- **Laravel Sanctum** - API 認證

### 前端技術
- **Bootstrap 5** - UI 框架
- **jQuery 3.7.1** - JavaScript 函式庫
- **Bootstrap Icons** - 圖示庫
- **Flatpickr** - 日期選擇器
- **TinyMCE** - 富文本編輯器

### 第三方整合
- **綠界金流** - 線上付款系統
- **Intervention Image** - 圖片處理

## 📋 系統需求

- PHP 8.1 或更高版本
- Composer
- Node.js & NPM
- MySQL 5.7+ 或 SQLite
- Web 伺服器 (Apache/Nginx)

## 🚀 安裝步驟

### 1. 克隆專案
```bash
git clone [repository-url]
cd rent-bike-new
```

### 2. 安裝 PHP 依賴
```bash
composer install
```

### 3. 環境設定
```bash
cp .env.example .env
php artisan key:generate
```

### 4. 資料庫設定
```bash
# 編輯 .env 檔案設定資料庫連線
php artisan migrate
php artisan db:seed
```

### 5. 安裝 Filament
```bash
php artisan filament:install --panels
php artisan vendor:publish --tag=filament-config
```

### 6. 建立管理員帳號
```bash
php artisan make:filament-user
```

### 7. 安裝前端依賴 (可選)
```bash
npm install
npm run dev
```

## 📁 專案結構

```
rent-bike-new/
├── app/
│   ├── Filament/Resources/          # Filament 資源
│   ├── Http/Controllers/           # 控制器
│   └── Models/                     # 資料模型
├── database/
│   ├── migrations/                 # 資料庫遷移
│   └── seeders/                    # 資料填充
├── resources/
│   └── views/                      # Blade 視圖
├── routes/
│   └── web.php                     # 路由定義
└── public/                         # 公開檔案
```

## 🗄 資料庫結構

### 主要資料表
- **members** - 會員資料
- **motorcycles** - 機車資訊
- **stores** - 商店資訊
- **orders** - 訂單主檔
- **order_details** - 訂單明細
- **carts** - 購物車
- **cart_details** - 購物車明細

## 🔐 安全功能

### 會員註冊安全
- 密碼強度驗證（至少8字元，包含大小寫字母和數字）
- 即時密碼強度檢查
- 密碼確認驗證
- 服務條款和隱私政策同意

### 資料保護
- CSRF 保護
- SQL 注入防護
- XSS 防護
- 個人資料加密儲存

## 💳 付款系統

### 綠界金流整合
- 信用卡付款
- ATM 轉帳
- 安全加密傳輸
- 付款狀態追蹤

## 📱 響應式設計

- 支援桌面、平板、手機
- Bootstrap 5 響應式框架
- 觸控友善介面

## 🌐 多語言支援

- 中文繁體介面
- Filament 中文化
- 可擴展多語言支援

## 🔧 開發工具

### 常用指令
```bash
# 清除快取
php artisan optimize:clear

# 重新生成 Filament 資源
php artisan filament:assets

# 查看路由
php artisan route:list

# 資料庫重置
php artisan migrate:fresh --seed
```

### 開發環境
- Laravel Sail (Docker)
- Laravel Telescope (除錯工具)
- Laravel Debugbar

## 📊 後台管理功能

### 儀表板
- 可用機車統計
- 已出租機車統計
- 預約統計
- 即時數據圖表

### 資源管理
- **機車管理**：CRUD 操作、圖片上傳、狀態管理
- **商店管理**：分店資訊、關聯機車
- **會員管理**：會員資料、租車記錄
- **訂單管理**：唯讀模式，查看所有訂單

## 🚨 重要注意事項

### 訂單管理限制
- 訂單系統為唯讀模式，不允許新增、編輯、刪除
- 確保資料完整性和審計追蹤
- 符合法規要求

### 檔案上傳
- 圖片自動壓縮和格式轉換
- 安全的檔案命名
- 儲存空間管理

## 🤝 貢獻指南

1. Fork 專案
2. 建立功能分支 (`git checkout -b feature/AmazingFeature`)
3. 提交變更 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 開啟 Pull Request

## 📄 授權

本專案採用 MIT 授權條款 - 詳見 [LICENSE](LICENSE) 檔案

## 📞 聯絡資訊

- 專案維護者：[您的姓名]
- 電子郵件：[您的郵箱]
- 專案連結：[GitHub 連結]

## 🙏 致謝

- [Laravel](https://laravel.com/) - 優秀的 PHP 框架
- [Filament](https://filamentphp.com/) - 強大的後台管理面板
- [Bootstrap](https://getbootstrap.com/) - 響應式 UI 框架
- [綠界科技](https://www.ecpay.com.tw/) - 金流服務

---

**版本**: 1.0.0  
**最後更新**: {{ date('Y年m月d日') }}
