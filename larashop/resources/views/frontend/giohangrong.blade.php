@extends('layouts.frontend')

@section('title', 'Giỏ hàng rỗng')

@section('content')
<main class="content-wrapper d-flex align-items-center justify-content-center">
    <div class="container py-5 text-center">
        <section class="text-center py-4 px-2 my-4 mx-auto" style="max-width: 636px">
            <div class="pb-4 mb-3 mx-auto" style="max-width: 524px">
                <svg class="d-block mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" width="100" viewBox="0 0 29.5 30">
                    <path class="text-body-tertiary" d="M10.7 24.5c-1.5 0-2.8 1.2-2.8 2.8s1.2 2.8 2.8 2.8 2.8-1.2 2.8-2.8-1.2-2.8-2.8-2.8zm11.1 0c-1.5 0-2.8 1.2-2.8 2.8s1.2 2.8 2.8 2.8 2.8-1.2 2.8-2.8-1.2-2.8-2.8-2.8zM8.7 18h16l4-10H7.3l-.5-2.5H2v2h3.4l3.3 10.5z" fill="currentColor"/>
                </svg>
            </div>
            <h5 class="mb-2">Giỏ hàng của bạn hiện đang trống!</h5>
            <p class="fs-sm mb-4">Khám phá nhiều mặt hàng chất lượng của chúng tôi và thêm sản phẩm yêu thích vào giỏ hàng ngay.</p>
            <a class="btn btn-dark rounded-pill px-4 py-2" href="{{ route('frontend.home') }}">Tiếp tục mua sắm</a>
        </section>
    </div>
</main>
@endsection