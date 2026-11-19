@extends('layouts.frontend')

@section('title', $baiviet->tieude ?? 'Untitled')

@section('content')
<main class="content-wrapper">
    <nav class="container pt-3 my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('frontend.baiviet') }}">Tin tức</a></li>
            <li class="breadcrumb-item active">Chi tiết</li>
        </ol>
    </nav>

    <section class="container mb-3">
        <div class="row">
            <div class="col-12">
                <!-- Post title -->
                <h1 class="h3 mb-4">{{ $baiviet->tieude }}</h1>

                <!-- Post meta -->
                <div class="nav align-items-center gap-2 border-bottom pb-4 mt-n1 mb-4">
                    <a class="nav-link text-body fs-xs text-uppercase p-0" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => $baiviet->ChuDe->tenchude_slug]) }}">{{ $baiviet->ChuDe->tenchude }}</a>
                    <hr class="vr my-1 mx-1">
                    <span class="text-body-tertiary fs-xs">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $baiviet->created_at)->format('d/m/Y') }}</span>
                    <hr class="vr my-1 mx-1">
                    <span class="text-body-tertiary fs-xs">{{ $baiviet->luotxem }} lượt xem</span>
                </div>

                <p class="fw-bold" style="text-align:justify">{{ $baiviet->tomtat }}</p>
                {!! $baiviet->noidung !!}

                <!-- Tags + Sharing -->
                <div class="d-sm-flex align-items-center justify-content-between py-4 mt-n2 mt-md-n3 mb-2 mb-sm-3 mb-md-0">
                    <div class="d-flex flex-wrap gap-2 mb-4 mb-sm-0 me-sm-4">
                        <a class="btn btn-outline-secondary px-3 mt-1 me-1" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => $baiviet->ChuDe->tenchude_slug]) }}">#{{ $baiviet->ChuDe->tenchude_slug }}</a>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="text-body-emphasis fs-sm fw-medium">Chia sẻ:</div>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="X (Twitter)">
                            <i class="ci-x"></i>
                        </a>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="Facebook">
                            <i class="ci-facebook"></i>
                        </a>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="Telegram">
                            <i class="ci-telegram"></i>
                        </a>
                    </div>
                </div>

                <!-- Reviews -->
                <div class="d-flex align-items-center mt-2 mb-3">
                    <h2 class="h3 mb-0">Bình luận</h2>
                    <button type="button" class="btn btn-secondary ms-auto" data-bs-toggle="modal" data-bs-target="#reviewForm">
                        <i class="ci-edit-3 fs-base ms-n1 me-2"></i> Đăng bình luận
                    </button>
                </div>

                @foreach($baiviet->BinhLuanBaiViet as $value)
                    <div class="py-2 mb-2">
                        <div class="d-flex align-items-center mb-3">
                            <img class="rounded-circle" src="{{ asset('public/assets/img/icons/avatar.jpg') }}" width="30" />
                            <div class="text-nowrap ps-2 me-2">
                                <span class="h6 mb-0">{{ $value->User->name }}</span>
                            </div>
                            <span class="text-body-secondary fs-sm ms-auto">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('d/m/Y') }}</span>
                        </div>
                        <p class="fs-sm" style="text-align:justify">{{ $value->noidungbinhluan }}</p>
                    </div>
                @endforeach

                <!-- Review form modal -->
                <div class="modal fade" id="reviewForm" data-bs-backdrop="static" tabindex="-1" aria-labelledby="reviewFormLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <form class="modal-content needs-validation" novalidate>
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="reviewFormLabel">Đăng bình luận</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-3 pt-0">
                                <div class="mb-3">
                                    <label for="review-name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="review-name" required />
                                    <div class="invalid-feedback">Vui lòng nhập tên của bạn!</div>
                                    <small class="form-text">Sẽ được hiển thị ở phần bình luận.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="review-email" class="form-label">Địa chỉ email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="review-email" required />
                                    <div class="invalid-feedback">Vui lòng cung cấp địa chỉ email hợp lệ!</div>
                                    <small class="form-text">Email sẽ không hiển thị và chỉ dùng để xác thực.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="review-text">Nội dung bình luận <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="4" id="review-text" required></textarea>
                                    <div class="invalid-feedback">Hãy viết bình luận nhé!</div>
                                    <small class="form-text">Bình luận của bạn phải có ít nhất 50 ký tự.</small>
                                </div>
                            </div>
                            <div class="modal-footer flex-nowrap gap-3 border-0 px-4">
                                <button type="reset" class="btn btn-secondary w-100 m-0" data-bs-dismiss="modal">Hủy bỏ</button>
                                <button type="submit" class="btn btn-primary w-100 m-0">Gửi bình luận</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Related articles -->
                <div class="mt-3">
                    <h2 class="h3 pb-2 pb-sm-3">Bài viết cùng chuyên mục</h2>
                    <div class="d-flex flex-column gap-4 mt-n3">
                        @php
                            function LayHinhAnhDauTien($strNoiDung)
                            {
                                $first_img = '';
                                ob_start();
                                ob_end_clean();
                                $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $strNoiDung, $matches);
                                if (empty($output))
                                    return asset('public/assets/img/blog/no-photo.jpg');
                                else
                                    return str_replace('&amp;', '&', $matches[1][0]);
                            }
                        @endphp

                        @foreach($baivietcungchuyemuc as $value)
                            <article class="row align-items-start align-items-md-center gx-0 gy-4 pt-3">
                                <div class="col-sm-4 pe-sm-4">
                                    <a class="ratio d-flex hover-effect-scale rounded overflow-hidden flex-md-shrink-0" href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->ChuDe->tenchude_slug, 'tieude_slug' => $value->tieude_slug . '-' . $value->id . '.html']) }}" style="--cz-aspect-ratio:calc(226 / 306 * 100%)">
                                        <img src="{{ LayHinhAnhDauTien($value->noidung) }}" class="hover-effect-target" alt="Image" />
                                    </a>
                                </div>
                                <div class="col-sm-8">
                                    <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                                        <a class="nav-link text-body fs-xs text-uppercase p-0" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => $value->ChuDe->tenchude_slug]) }}">{{ $value->ChuDe->tenchude }}</a>
                                        <hr class="vr my-1 mx-1">
                                        <span class="text-body-tertiary fs-xs">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('d/m/Y') }}</span>
                                    </div>
                                    <h3 class="h5 mb-2 mb-md-3">
                                        <a class="hover-effect-underline" href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->ChuDe->tenchude_slug, 'tieude_slug' => $value->tieude_slug . '-' . $value->id . '.html']) }}">{{ $value->tieude }}</a>
                                    </h3>
                                    <p class="mb-0">{{ $value->tomtat }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection