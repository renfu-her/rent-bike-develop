# 🏍️ 機車出租網站

一個基於 Laravel 12 和 Filament 3 的完整機車出租管理系統。

## 🚀 功能特色

### 📊 後台管理 (Filament)
- **機車配件管理**: 完整的 CRUD 操作，狀態篩選
- **商店管理**: 商店資訊管理，狀態控制
- **機車管理**: 機車資訊、配件選擇、狀態管理
- **會員管理**: 會員資料管理
- **訂單管理**: 訂單查詢、狀態管理
- **儀表板**: 今日待租車、待還車、預約車子統計

### 🌐 前台網站 (Blade + Bootstrap 5)
- **響應式設計**: 使用 Bootstrap 5 和 jQuery
- **首頁**: 特色介紹、統計數據、行動呼籲
- **機車列表**: 搜尋、篩選、詳細資訊模態框
- **商店列表**: 商店資訊展示
- **聯絡我們**: 聯絡表單和資訊
- **預約系統**: 完整的預約流程

## 🛠️ 技術架構

- **後端**: Laravel 12 + Filament 3
- **前端**: Blade + Bootstrap 5 + jQuery
- **資料庫**: SQLite (可切換到 MySQL)
- **圖片處理**: Intervention Image
- **日期選擇**: Flatpickr
- **富文本編輯**: TinyMCE

## 📋 系統需求

- PHP 8.2+
- Composer
- Node.js (可選，用於前端資源編譯)

## 🚀 安裝步驟

1. **克隆專案**
```bash
git clone <repository-url>
cd rent-bike-new
```

2. **安裝依賴**
```bash
composer install
```

3. **環境設定**
```bash
cp .env.example .env
php artisan key:generate
```

4. **資料庫設定**
```bash
# 使用 SQLite (預設)
touch database/database.sqlite

# 或修改 .env 使用 MySQL
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=rent_bike_new
# DB_USERNAME=root
# DB_PASSWORD=
```

5. **執行遷移和填充資料**
```bash
php artisan migrate
php artisan db:seed --class=MotorcycleRentalSeeder
```

6. **創建 Filament 管理員帳號**
```bash
php artisan make:filament-user
```

7. **啟動開發服務器**
```bash
php artisan serve
```

## 🌐 訪問網站

- **前台網站**: http://localhost:8000
- **後台管理**: http://localhost:8000/admin

### 後台登入資訊
- 帳號: `admin@admin.com`
- 密碼: `admin` (或您設定的密碼)

## 📊 資料庫結構

### 主要資料表
- **motorcycle_accessories**: 機車配件 (型號、數量、狀態)
- **stores**: 商店 (名稱、電話、地址、狀態)
- **members**: 會員 (名稱、身份證字號、電話、地址)
- **motorcycles**: 機車 (商店ID、名稱、型號、配件、車牌、價格)
- **orders**: 訂單 (商店ID、會員ID、總價、租車日期、成交狀態)
- **order_details**: 訂單明細 (訂單ID、機車ID、數量、小計、總計)

## 🎯 主要功能

### 前台功能
1. **首頁展示**: 網站介紹、特色說明、統計數據
2. **機車瀏覽**: 搜尋、篩選、詳細資訊查看
3. **商店資訊**: 商店列表、詳細資訊
4. **預約系統**: 完整的預約流程
5. **聯絡我們**: 聯絡表單

### 後台功能
1. **資料管理**: 所有資料的 CRUD 操作
2. **狀態管理**: 機車、配件、商店狀態控制
3. **訂單管理**: 訂單查詢、狀態更新
4. **統計儀表板**: 即時統計數據
5. **用戶管理**: 管理員帳號管理

## 📈 儀表板統計

- **今日待租車**: 可出租機車數量
- **今日待還車**: 已出租機車數量
- **預約車子**: 未來預約數量

## 🎨 自訂功能

### 新增機車配件
1. 登入後台
2. 進入「機車配件管理」
3. 點擊「新增」
4. 填寫配件資訊

### 新增商店
1. 登入後台
2. 進入「商店管理」
3. 點擊「新增」
4. 填寫商店資訊

### 新增機車
1. 登入後台
2. 進入「機車管理」
3. 點擊「新增」
4. 選擇商店、填寫機車資訊、選擇配件

## 🔧 開發說明

### 新增頁面
1. 創建控制器: `php artisan make:controller NewController`
2. 定義路由: 在 `routes/web.php` 中新增
3. 創建視圖: 在 `resources/views/` 中新增 Blade 檔案

### 新增 Filament 資源
```bash
php artisan make:filament-resource NewModel --generate
```

### 資料庫遷移
```bash
php artisan make:migration create_new_table
php artisan migrate
```

## 📝 注意事項

1. **檔案權限**: 確保 `storage` 和 `bootstrap/cache` 目錄可寫入
2. **環境變數**: 根據部署環境調整 `.env` 設定
3. **資料備份**: 定期備份資料庫
4. **安全性**: 定期更新依賴套件

## 🤝 貢獻

歡迎提交 Issue 和 Pull Request 來改善這個專案。

## 📄 授權

此專案採用 MIT 授權條款。

## 📞 聯絡資訊

如有任何問題，請聯絡開發團隊。

---

**機車出租網站** - 讓您的旅程更加便利！ 🏍️✨
