<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đăng ký tài khoản | {{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('public/assets/icons/cartzilla-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/css/theme.min.css') }}" />
</head>
<body>
<main class="content-wrapper w-100 px-3 ps-lg-5 pe-lg-4 mx-auto" style="max-width: 1920px">
    <div class="d-lg-flex">
        <div class="d-flex flex-column min-vh-100 w-100 py-4 mx-auto me-lg-5" style="max-width: 416px">
            <header class="navbar px-0 pb-4">
                <a class="navbar-brand" href="{{ route('frontend.home') }}">{{ config('app.name', 'Laravel') }}</a>
            </header>
            <h1 class="h2 mt-auto">Đăng ký tài khoản</h1>
            <div class="nav fs-sm mb-4">
                Tôi đã có tài khoản <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('user.dangnhap') }}">Đăng nhập</a>
            </div>
            <form method="post" action="{{ route('register') }}" class="needs-validation" novalidate>
                @csrf
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required />
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ email</label>
                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required />
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required />
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control form-control-lg" name="password_confirmation" required />
                </div>
                <button type="submit" class="btn btn-lg btn-primary w-100">Tạo tài khoản</button>
            </form>
            <footer class="mt-auto pt-4">
                <p class="fs-xs mb-0">Bản quyền &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}.</p>
            </footer>
        </div>
    </div>
</main>
<script src="{{ asset('public/assets/js/theme.min.js') }}"></script>
</body>
</html>