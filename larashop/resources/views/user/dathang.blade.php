@extends('layouts.frontend')

@section('title', 'Thanh toán đơn hàng')

@section('content')
<main class="content-wrapper">
    <nav class="container pt-3 my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('frontend.giohang') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-item active">Thanh toán đơn hàng</li>
        </ol>
    </nav>

    <div class="container mb-5">
        <div class="row pt-2 pb-2">
            <!-- Cột điền thông tin -->
            <div class="col-lg-7 position-relative z-2 mb-4 mb-lg-0">
                <div class="d-flex align-items-start mb-4">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold flex-shrink-0" style="width: 2rem; height: 2rem">1</div>
                    <div class="w-100 ps-3">
                        <h2 class="h5 mb-3">Thông tin giao hàng</h2>
                        <form id="checkout-form" action="{{ route('user.dathang.post') }}" method="post" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và tên người nhận <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name ?? '' }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="dienthoaigiaohang" class="form-label">Điện thoại giao hàng <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('dienthoaigiaohang') is-invalid @enderror" id="dienthoaigiaohang" name="dienthoaigiaohang" required />
                                @error('dienthoaigiaohang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="diachigiaohang" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('diachigiaohang') is-invalid @enderror" id="diachigiaohang" name="diachigiaohang" required />
                                @error('diachigiaohang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="submit" id="checkout-form-submit" hidden />
                        </form>
                    </div>
                </div>

                <div class="d-flex align-items-start pt-3 border-top">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold flex-shrink-0" style="width: 2rem; height: 2rem">2</div>
                    <div class="w-100 ps-3">
                        <h2 class="h5 mb-3">Hình thức thanh toán</h2>
                        <div class="form-check mb-3">
                            <input type="radio" class="form-check-input" name="payment-method" id="payment-cod" value="cod" checked />
                            <label class="form-check-label text-dark-emphasis fw-semibold" for="payment-cod">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="accept-terms" checked required />
                            <label for="accept-terms" class="form-check-label">
                                Tôi đồng ý với các <a href="#" class="text-decoration-underline">Điều khoản & Điều kiện</a>
                            </label>
                        </div>

                        <!-- Nút hoàn tất đặt hàng kích hoạt submit của form -->
                        <label for="checkout-form-submit" class="btn btn-lg btn-primary w-100 cursor-pointer">
                            Xác nhận đặt hàng ({{ Cart::total() ?? 0 }}<small>đ</small>)
                        </label>
                    </div>
                </div>
            </div>

            <!-- Cột tóm tắt đơn hàng bên phải -->
            <aside class="col-lg-5 col-xl-4 offset-xl-1">
                <div class="position-sticky top-0 bg-body-tertiary rounded-4 p-4">
                    <h5 class="border-bottom pb-3 mb-3">Đơn hàng của bạn</h5>
                    <div class="d-flex flex-column gap-3 mb-4">
                        @foreach (Cart::content() as $value)
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/app/private/' . $value->options->image) }}" width="60" class="rounded" alt="{{ $value->name }}" />
                                <div class="w-100 min-w-0 ps-3">
                                    <div class="fs-sm fw-medium text-truncate">{{ $value->name }}</div>
                                    <div class="fs-xs text-body-secondary">SL: {{ $value->qty }} x {{ number_format($value->price, 0, ',', '.') }}đ</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <ul class="list-unstyled fs-sm gap-2 mb-0">
                        <li class="d-flex justify-content-between">
                            <span>Tiền hàng:</span>
                            <span class="fw-medium">{{ Cart::priceTotal() }}<small>đ</small></span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span>Thuế VAT:</span>
                            <span class="fw-medium">{{ Cart::tax() }}<small>đ</small></span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span>Phí vận chuyển:</span>
                            <span class="fw-medium">Miễn phí</span>
                        </li>
                    </ul>

                    <div class="border-top pt-3 mt-3 d-flex justify-content-between">
                        <span class="fw-bold">Tổng thanh toán:</span>
                        <span class="h5 mb-0 text-primary">{{ Cart::total() }}<small>đ</small></span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection