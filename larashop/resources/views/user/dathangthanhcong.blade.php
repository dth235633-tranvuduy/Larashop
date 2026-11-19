@extends('layouts.frontend')

@section('title', 'Hoàn tất đặt hàng')

@section('content')
<main class="content-wrapper">
    <section class="container my-5 text-center">
        <div class="position-relative overflow-hidden rounded-5 p-5 bg-light-subtle border">
            <div class="py-4 mx-auto" style="max-width: 536px">
                <i class="ci-check-circle text-success display-1 mb-3"></i>
                <h1 class="h3 mb-3">Cảm ơn bạn đã đặt hàng!</h1>
                <p class="text-body-secondary mb-4">Đơn hàng của bạn đã được tiếp nhận thành công và sẽ được xử lý trong thời gian sớm nhất.</p>
                <a class="btn btn-lg btn-dark rounded-pill px-4" href="{{ route('frontend.home') }}">Tiếp tục mua sắm</a>
            </div>
        </div>
    </section>
</main>
@endsection