# Larashop

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/SQLite-Database-003B57?logo=sqlite&logoColor=white" alt="SQLite">
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Sass-Scss-CC6699?logo=sass&logoColor=white" alt="Sass">
  <img src="https://img.shields.io/badge/Vite-7-646CFF?logo=vite&logoColor=white" alt="Vite">
</p>

Website thương mại điện tử được xây dựng bằng Laravel, phục vụ việc giới thiệu và bán các sản phẩm công nghệ. Đồ án bao gồm giao diện dành cho khách hàng, khu vực tài khoản người dùng và trang quản trị hệ thống.

## Chức năng chính

### Khách hàng

- Xem sản phẩm theo danh mục, hãng sản xuất và thông tin chi tiết.
- Tìm kiếm và duyệt các sản phẩm đang bán.
- Thêm, xóa, tăng hoặc giảm số lượng sản phẩm trong giỏ hàng.
- Đăng ký, đăng nhập, đăng xuất và khôi phục mật khẩu.
- Đặt hàng và xem trạng thái đơn hàng.
- Quản lý thông tin cá nhân và đổi mật khẩu.
- Đăng nhập bằng Google OAuth.
- Xem bài viết, chủ đề và bình luận bài viết.

### Quản trị viên

- Quản lý loại sản phẩm, hãng sản xuất và tình trạng sản phẩm.
- Thêm, sửa, xóa và cập nhật sản phẩm.
- Nhập dữ liệu và xuất dữ liệu sản phẩm, hãng sản xuất bằng Excel.
- Quản lý đơn hàng và cập nhật trạng thái đơn hàng.
- Quản lý tài khoản người dùng.
- Quản lý chủ đề, bài viết và bình luận bài viết.
- Kiểm duyệt hoặc kích hoạt bài viết, bình luận.

## Công nghệ sử dụng

- **Backend:** PHP 8.2+, Laravel 12.
- **Frontend:** Blade Template, Bootstrap, Sass, Tailwind CSS.
- **Build tool:** Vite.
- **Cơ sở dữ liệu mặc định:** SQLite.
- **Thư viện bổ sung:** Laravel UI, Laravel Socialite, Laravel Shopping Cart và Laravel Excel.

## Yêu cầu cài đặt

Trước khi chạy dự án, cần cài đặt:

- PHP >= 8.2.
- Composer.
- Node.js và npm.
- SQLite hoặc một hệ quản trị cơ sở dữ liệu tương thích.

Kiểm tra phiên bản:

```bash
php -v
composer -V
node -v
npm -v
```

## Cài đặt dự án

### 1. Clone mã nguồn

```bash
git clone <URL_REPOSITORY>
cd larashop
```

### 2. Cài đặt thư viện PHP

```bash
composer install
```

### 3. Cấu hình môi trường

Tạo file `.env` từ file mẫu:

```bash
copy .env.example .env
```

Trên macOS/Linux có thể dùng:

```bash
cp .env.example .env
```

Tạo khóa ứng dụng:

```bash
php artisan key:generate
```

### 4. Cấu hình cơ sở dữ liệu

Dự án đang sử dụng SQLite. Đảm bảo file sau tồn tại:

```text
database/database.sqlite
```

Nếu file chưa có, tạo file rỗng:

```bash
type nul > database\database.sqlite
```

Kiểm tra `.env` có cấu hình:

```env
DB_CONNECTION=sqlite
```

Chạy migration và dữ liệu mẫu:

```bash
php artisan migrate --seed
```

### 5. Cài đặt thư viện frontend

```bash
npm install
```

## Chạy dự án

### Chạy môi trường phát triển

Mở hai cửa sổ terminal tại thư mục dự án.

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

Truy cập website tại:

```text
http://127.0.0.1:8000
```

### Build frontend cho production

```bash
npm run build
```

## Các đường dẫn chính

| Khu vực            | Đường dẫn   |
| ------------------ | ----------- |
| Trang chủ          | `/`         |
| Danh sách sản phẩm | `/san-pham` |
| Giỏ hàng           | `/gio-hang` |
| Bài viết           | `/bai-viet` |
| Đăng nhập          | `/login`    |
| Khu vực người dùng | `/user`     |
| Khu vực quản trị   | `/admin`    |

Khu vực `/admin` yêu cầu người dùng đăng nhập trước khi truy cập.

## Cấu trúc thư mục

```text
app/
├── Http/Controllers/   # Controller cho frontend, user và admin
├── Models/              # Các model Eloquent
├── Imports/             # Nhập dữ liệu từ Excel
└── Exports/             # Xuất dữ liệu ra Excel

database/
├── migrations/          # Cấu trúc các bảng dữ liệu
├── seeders/             # Dữ liệu khởi tạo
└── database.sqlite      # Cơ sở dữ liệu SQLite

resources/views/
├── frontend/            # Giao diện khách hàng
├── user/                # Giao diện tài khoản người dùng
├── admin/               # Giao diện quản trị
├── auth/                # Đăng nhập, đăng ký, khôi phục mật khẩu
└── layouts/             # Layout dùng chung

public/                  # Tài nguyên tĩnh: CSS, JavaScript, hình ảnh
routes/web.php           # Khai báo các route của ứng dụng
```

## Chạy kiểm thử

```bash
php artisan test
```

Hoặc sử dụng script đã cấu hình trong Composer:

```bash
composer test
```

## Một số lệnh Artisan hữu ích

```bash
# Xóa cache cấu hình
php artisan config:clear

# Xóa toàn bộ cache ứng dụng
php artisan optimize:clear

# Xem danh sách route
php artisan route:list

# Làm mới cơ sở dữ liệu và chạy lại seeder
php artisan migrate:fresh --seed
```

## Tác giả

- **Họ tên:** Trần Vũ Duy
- **Mã sinh viên:** DTH235633
- **Môn học:** Công nghệ Web - PHP

## Bản quyền

Đây là đồ án học tập, được phát triển cho mục đích nghiên cứu và thực hành.
