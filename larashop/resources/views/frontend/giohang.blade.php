@extends('layouts.frontend')

@section('title', 'Giỏ hàng')

@section('content')
<main class="content-wrapper">
    <nav class="container pt-3 my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Giỏ hàng</li>
        </ol>
    </nav>

    <section class="container mb-3">
        <h1 class="h3 mb-2">Giỏ hàng</h1>
        <div class="row">
            <!-- Danh sách sản phẩm -->
            <div class="col-lg-8">
                <div class="pe-lg-2 pe-xl-3 me-xl-3">
                    <table class="table position-relative z-2 mb-4">
                        <thead>
                            <tr>
                                <th scope="col" class="fs-sm fw-normal py-3 ps-0"><span class="text-body">Sản phẩm</span></th>
                                <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-xl-table-cell">Đơn giá</th>
                                <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell">Số lượng</th>
                                <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell">Thành tiền</th>
                                <th scope="col" class="py-0 px-0 text-end"></th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach (Cart::content() as $value)
                                <tr>
                                    <td class="py-3 ps-0">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/app/private/' . $value->options->image) }}" width="100" class="rounded" alt="{{ $value->name }}" />
                                            <div class="w-100 min-w-0 ps-2 ps-xl-3">
                                                <h5 class="d-flex animate-underline mb-2">
                                                    <a class="d-block fs-sm fw-medium text-truncate animate-target" href="#">{{ $value->name }}</a>
                                                </h5>
                                                <ul class="list-unstyled gap-1 fs-xs mb-0 d-xl-none">
                                                    <li>
                                                        <span class="text-body-secondary">Đơn giá:</span>
                                                        <span class="text-dark-emphasis fw-medium">{{ number_format($value->price, 0, ',', '.') }}<small>đ</small></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="h6 py-3 d-none d-xl-table-cell">{{ number_format($value->price, 0, ',', '.') }}<small>đ</small></td>
                                    <td class="py-3 d-none d-md-table-cell">
                                        <div class="count-input d-flex align-items-center gap-1">
                                            <a href="{{ route('frontend.giohang.giam', ['row_id' => $value->rowId]) }}" class="btn btn-sm btn-icon btn-outline-secondary">
                                                <i class="ci-minus"></i>
                                            </a>
                                            <input type="number" class="form-control form-control-sm text-center" style="width: 50px" value="{{ $value->qty }}" readonly />
                                            <a href="{{ route('frontend.giohang.tang', ['row_id' => $value->rowId]) }}" class="btn btn-sm btn-icon btn-outline-secondary">
                                                <i class="ci-plus"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="h6 py-3 d-none d-md-table-cell">{{ number_format($value->price * $value->qty, 0, ',', '.') }}<small>đ</small></td>
                                    <td class="text-end py-3 px-0">
                                        <a href="{{ route('frontend.giohang.xoa', ['row_id' => $value->rowId]) }}" class="btn btn-icon btn-sm text-danger" title="Xóa">
                                            <i class="ci-trash fs-base"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="nav position-relative z-2 mb-4 mb-lg-0">
                        <a class="nav-link animate-underline px-0" href="{{ route('frontend.home') }}">
                            <i class="ci-chevron-left fs-lg me-1"></i>
                            <span class="animate-target">Tiếp tục mua hàng</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tóm tắt đơn hàng -->
            <aside class="col-lg-4">
                <div class="position-sticky top-0" style="padding-top: 20px">
                    <div class="bg-body-tertiary rounded-4 p-4 mb-3">
                        <h5 class="border-bottom pb-4 mb-4">Tóm tắt đơn hàng</h5>
                        <ul class="list-unstyled fs-sm gap-3 mb-0">
                            <li class="d-flex justify-content-between mb-2">
                                Tổng tiền ({{ Cart::count() ?? 0 }} sản phẩm):
                                <span class="text-dark-emphasis fw-medium">{{ Cart::priceTotal() }}<small>đ</small></span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                Giảm giá:
                                <span class="text-danger fw-medium">{{ Cart::discount() }}<small>đ</small></span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                Thuế VAT:
                                <span class="text-dark-emphasis fw-medium">{{ Cart::tax() }}<small>đ</small></span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                Phí vận chuyển:
                                <span class="text-dark-emphasis fw-medium">Miễn phí</span>
                            </li>
                        </ul>
                        <div class="border-top pt-4 mt-4">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fs-base fw-bold">Tổng ước tính:</span>
                                <span class="h5 mb-0 text-primary">{{ Cart::total() }}<small>đ</small></span>
                            </div>
                            <a class="btn btn-lg btn-primary w-100" href="{{ route('user.dathang') }}">
                                Tiến hành thanh toán
                                <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</main>
@endsection