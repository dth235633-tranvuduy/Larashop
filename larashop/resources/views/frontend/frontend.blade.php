<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" data-pwa="true">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Trang chủ') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('public/assets/img/app-icons/icon-32x32.png') }}" sizes="32x32" />
    <script src="{{ asset('public/assets/js/theme-switcher.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/assets/icons/cartzilla-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/swiper/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/simplebar/simplebar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/css/theme.min.css') }}" id="theme-styles" />
    @yield('css')
</head>
<body>
    <!-- Shopping cart offcanvas -->
    <div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1" style="width: 500px">
        <!-- Header -->
        <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
            <div class="d-flex align-items-center justify-content-between w-100">
                <h4 class="offcanvas-title" id="shoppingCartLabel">Giỏ hàng ({{ Cart::count() ?? 0 }})</h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
        </div>

        @if(Cart::count() > 0)
            <!-- Items -->
            <div class="offcanvas-body d-flex flex-column gap-4 pt-2">
                @foreach (Cart::content() as $value)
                    <div class="d-flex align-items-center">
                        <a class="flex-sm-shrink-0" href="#" style="width: 142px">
                            <div class="ratio bg-body-tertiary rounded overflow-hidden" style="--cz-aspect-ratio: calc(110 / 142 * 100%)">
                                <img src="{{ asset('storage/app/private/' . $value->options->image) }}" alt="{{ $value->name }}" />
                            </div>
                        </a>
                        <div class="w-100 min-w-0 ps-3">
                            <h5 class="d-flex animate-underline mb-2">
                                <a class="d-block fs-sm fw-medium text-truncate animate-target" href="#">{{ $value->name }}</a>
                            </h5>
                            <div class="d-flex align-items-center justify-content-between gap-1">
                                <div class="h6 mt-1 mb-0">{{ number_format($value->price, 0, ',', '.') }}<small>đ</small></div>
                                <a href="{{ route('frontend.giohang.xoa', ['row_id' => $value->rowId]) }}" 
                                   class="btn btn-icon btn-sm flex-shrink-0" 
                                   data-bs-toggle="tooltip" 
                                   title="Xóa khỏi giỏ">
                                    <i class="ci-trash fs-base"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer -->
            <div class="offcanvas-header flex-column align-items-start">
                <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
                    <span class="text-light-emphasis">Tổng tiền:</span>
                    <span class="h6 mb-0">{{ Cart::priceTotal() }}<small>đ</small></span>
                </div>
                <a class="btn btn-lg btn-dark w-100 rounded-pill" href="{{ route('frontend.giohang') }}">Xem chi tiết giỏ hàng</a>
            </div>
        @else
            <!-- Empty State -->
            <div class="offcanvas-body text-center">
                <svg class="d-block mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" width="60" viewBox="0 0 29.5 30">
                    <path class="text-body-emphasis" d="M10.7 24.5c-1.5 0-2.8 1.2-2.8 2.8s1.2 2.8 2.8 2.8 2.8-1.2 2.8-2.8-1.2-2.8-2.8-2.8zm11.1 0c-1.5 0-2.8 1.2-2.8 2.8s1.2 2.8 2.8 2.8 2.8-1.2 2.8-2.8-1.2-2.8-2.8-2.8zM8.7 18h16l4-10H7.3l-.5-2.5H2v2h3.4l3.3 10.5z" fill="currentColor"/>
                </svg>
                <h6 class="mb-2">Giỏ hàng của bạn hiện đang trống!</h6>
                <p class="fs-sm mb-4">Khám phá nhiều mặt hàng của chúng tôi và thêm sản phẩm vào giỏ hàng.</p>
                <a class="btn btn-dark rounded-pill" href="{{ route('frontend.home') }}">Tiếp tục mua sắm</a>
            </div>
        @endif
    </div>

    <!-- Navigation Header -->
    <header class="navbar navbar-expand-lg bg-body navbar-sticky sticky-top z-fixed px-0" data-sticky-element>
        <div class="container flex-nowrap">
            <button type="button" class="navbar-toggler me-4 me-lg-0" data-bs-toggle="offcanvas" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand py-1 py-md-2 py-xl-1" href="{{ route('frontend.home') }}">
                <span class="d-none d-sm-flex flex-shrink-0 text-primary me-2">
                    <i class="ci-shopping-bag fs-2"></i>
                </span>
                {{ config('app.name', 'Laravel') }}
            </a>
            <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1">
                <div class="offcanvas-header py-3">
                    <h5 class="offcanvas-title">{{ config('app.name', 'Laravel') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body pt-3 pb-4 py-lg-0 mx-lg-auto">
                    <ul class="navbar-nav position-relative">
                        <li class="nav-item py-lg-2 me-lg-n2 me-xl-0">
                            <a class="nav-link" href="{{ route('frontend.home') }}"><i class="ci-home me-2"></i>Trang chủ</a>
                        </li>
                        <li class="nav-item dropdown py-lg-2 me-lg-n1 me-xl-0">
                            <a class="nav-link dropdown-toggle" href="{{ route('frontend.sanpham') }}" role="button" data-bs-toggle="dropdown">
                                <i class="ci-gift me-2"></i>Sản phẩm
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('frontend.sanpham.phanloai', ['tenloai_slug' => 'dien-thoai']) }}">Điện thoại</a></li>
                                <li><a class="dropdown-item" href="{{ route('frontend.sanpham.phanloai', ['tenloai_slug' => 'may-tinh-bang']) }}">Máy tính bảng</a></li>
                                <li><a class="dropdown-item" href="{{ route('frontend.sanpham.phanloai', ['tenloai_slug' => 'may-tinh-xach-tay']) }}">Máy tính xách tay</a></li>
                            </ul>
                        </li>
                        <li class="nav-item py-lg-2 me-lg-n2 me-xl-0">
                            <a class="nav-link" href="{{ route('frontend.baiviet') }}"><i class="ci-globe me-2"></i>Tin tức</a>
                        </li>
                        <li class="nav-item py-lg-2 me-lg-n2 me-xl-0">
                            <a class="nav-link" href="{{ route('frontend.tuyendung') }}"><i class="ci-target me-2"></i>Tuyển dụng</a>
                        </li>
                        <li class="nav-item py-lg-2 me-lg-n2 me-xl-0">
                            <a class="nav-link" href="{{ route('frontend.lienhe') }}"><i class="ci-chat me-2"></i>Liên hệ</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="d-flex align-items-center">
                <!-- User account button -->
                <a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-shake me-2" href="{{ route('user.home') }}">
                    <i class="ci-user animate-target"></i>
                </a>

                <!-- Cart button (Mở Offcanvas giỏ hàng) -->
                <button type="button" class="btn btn-icon btn-lg fs-xl btn-outline-secondary position-relative border-0 rounded-circle animate-scale" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart">
                    <span class="position-absolute top-0 start-100 badge fs-xs text-bg-primary rounded-pill mt-1 ms-n4 z-2" style="--cz-badge-padding-y: .25em; --cz-badge-padding-x: .42em;">
                        {{ Cart::count() ?? 0 }}
                    </span>
                    <i class="ci-shopping-bag animate-target me-1"></i>
                </button>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="footer pb-4 pt-4 border-top">
        <div class="container text-center">
            <p class="fs-xs mb-0">Bản quyền &copy; {{ date('Y') }} bởi {{ config('app.name', 'Laravel') }}.</p>
        </div>
    </footer>

    @yield('floating-button')
    <script src="{{ asset('public/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/theme.min.js') }}"></script>
    @yield('javascript')
</body>
</html>