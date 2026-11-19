@extends('layouts.frontend')
@section('title', 'Hồ sơ khách hàng')

@section('content')
<main class="content-wrapper">
    <nav class="container pt-3 my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Hồ sơ cá nhân</li>
        </ol>
    </nav>
    <div class="container mt-4 mb-5">
        <div class="row">
            <aside class="col-lg-3">
                <div class="d-flex align-items-center mb-4">
                    <div class="h5 d-flex justify-content-center align-items-center text-primary bg-primary-subtle rounded-circle mb-0" style="width: 3rem; height: 3rem">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="ps-3">
                        <h5 class="h6 mb-0">{{ $user->name }}</h5>
                        <span class="text-body fw-normal small">Khách hàng</span>
                    </div>
                </div>
                <div class="list-group list-group-borderless">
                    <a class="list-group-item list-group-item-action active" href="{{ route('user.home') }}"><i class="ci-user me-2"></i> Hồ sơ cá nhân</a>
                    <a class="list-group-item list-group-item-action" href="{{ route('user.donhang') }}"><i class="ci-shopping-bag me-2"></i> Đơn hàng của tôi</a>
                    <a class="list-group-item list-group-item-action" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="ci-log-out me-2"></i> Đăng xuất
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">@csrf</form>
                </div>
            </aside>
            <div class="col-lg-9">
                <h1 class="h2 mb-3">Hồ sơ cá nhân</h1>
                @if (session('warning'))
                    <div class="alert alert-danger" role="alert">{{ session('warning') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif
                
                <!-- Form thông tin cơ bản -->
                <div class="border-bottom py-4">
                    <h2 class="h6 mb-3">Thông tin cơ bản</h2>
                    <form action="{{ route('user.hoso') }}" method="post" class="row g-3">
                        @csrf
                        <div class="col-sm-6">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required />
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Địa chỉ email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required />
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Cập nhật hồ sơ</button>
                        </div>
                    </form>
                </div>

                <!-- Form đổi mật khẩu -->
                <div class="py-4">
                    <h2 class="h6 mb-3">Đổi mật khẩu</h2>
                    <form action="{{ route('user.doimatkhau') }}" method="post" class="row g-3">
                        @csrf
                        <div class="col-sm-6">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required />
                            @error('old_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required />
                            @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" name="new_password_confirmation" required />
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

