@extends('layouts.frontend')

@section('title', $title ?? 'Tất cả tin tức')

@section('content')
<main class="content-wrapper">
    <nav class="container pt-3 my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('frontend.baiviet') }}">Tin tức</a></li>
            <li class="breadcrumb-item active">{{ $title ?? 'Tất cả tin tức' }}</li>
        </ol>
    </nav>

    <h1 class="h3 container mb-4">{{ $title ?? 'Tất cả tin tức' }}</h1>

    <section class="container mb-3">
        <div class="row">
            <div class="col-12">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 gy-5">
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

                    @foreach($baiviet as $value)
                        <article class="col">
                            <a class="ratio d-flex hover-effect-scale rounded overflow-hidden" href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->ChuDe->tenchude_slug, 'tieude_slug' => $value->tieude_slug . '-' . $value->id . '.html']) }}" style="--cz-aspect-ratio:calc(305 / 416 * 100%)">
                                <img src="{{ LayHinhAnhDauTien($value->noidung) }}" class="hover-effect-target" alt="Image" />
                            </a>
                            <div class="pt-4">
                                <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                                    <a class="nav-link text-body fs-xs text-uppercase p-0" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => $value->ChuDe->tenchude_slug]) }}">{{ $value->ChuDe->tenchude }}</a>
                                    <hr class="vr my-1 mx-1">
                                    <span class="text-body-tertiary fs-xs">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('d/m/Y') }}</span>
                                </div>
                                <h3 class="h5 mb-0">
                                    <a class="hover-effect-underline" href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->ChuDe->tenchude_slug, 'tieude_slug' => $value->tieude_slug . '-' . $value->id . '.html']) }}">{{ $value->tieude }}</a>
                                </h3>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                {{ $baiviet->links('vendor.pagination.frontend-pagination') }}
            </div>
        </div>
    </section>
</main>
@endsection