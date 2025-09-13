@extends('customers.layouts.master')

@push('styles')
<style>
    .about-section-bg {
        background-color: #0b1c2c;
        background-image:
            linear-gradient(rgba(11,28,44,0.6), rgba(11,28,44,0.6)),
            url('/assets/img/gallery/background_danmask_1.jpg');
        background-position: center;
        background-repeat: repeat;
        background-size: auto;
        background-attachment: fixed;
        position: relative;
        border-bottom: 3px solid var(--anphu-gold);
    }

    .heading-about {
        text-align: center;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        background: linear-gradient(90deg,#d6aa3a,#d4a537);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        text-shadow:0 0 10px rgba(201,176,55,0.6);
    }

    .about-content {
        background-color: var(--navy-dark);
        color: white;
        padding: 2rem;
        text-align: center;
        font-size: 1.05rem;
        line-height: 1.75;
        margin-bottom: 1rem;
    }

    /* Carousel */
    .about-carousel {
        width: 100%;
        position: relative; /* cho indicators hoạt động */
        z-index: 1;
    }

    .about-carousel .carousel-item {
        height: 50vh; /* ảnh vừa khung, không quá cao */
    }

    .about-carousel .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 1px solid var(--anphu-gold);
    }

    /* Slide mượt */
    .carousel-inner .carousel-item {
        transition: transform 0.8s ease, opacity 0.8s ease;
    }

    /* Indicators */
    .carousel-indicators.custom-indicators {
        position: absolute;
        bottom: -48px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        padding-left: 0;
        margin: 0;
        list-style: none;
        z-index: 20; /* cao hơn carousel */
        pointer-events: auto; /* bật click */
    }

    .carousel-indicators.custom-indicators li {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255,255,255,0.5);
        margin: 0 6px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .carousel-indicators.custom-indicators li.active,
    .carousel-indicators.custom-indicators li:hover {
        background-color: var(--anphu-gold);
        transform: scale(1.2);
    }
</style>
@endpush

@section('content')
<section class="py-5 about-section-bg">
    <div class="col-md-12 about-img" data-aos="fade-left">
        @php
            preg_match_all('/<img[^>]+src="([^">]+)"/i', $page->custom_content_1 ?? '', $matches);
            $images = array_unique($matches[1] ?? []);
        @endphp

        @if(count($images) > 0)
            <div id="aboutImageCarousel" class="carousel slide about-carousel mb-4" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($images as $index => $img)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ $img }}" alt="Slide {{ $index + 1 }}">
                        </div>
                    @endforeach
                </div>

                {{-- Indicators --}}
                <ol class="carousel-indicators custom-indicators">
                    @foreach($images as $index => $img)
                        <li data-target="#aboutImageCarousel" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>

                <a class="carousel-control-prev" href="#aboutImageCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next" href="#aboutImageCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
            </div>
        @else
            <p class="text-center">Chưa có hình ảnh liên hệ nào.</p>
        @endif
    </div>
    <hr>
    <div class="container">
        <div class="row">
            {{-- Sơ lược --}}
            <div class="col-md-12 about-content" data-aos="fade-right">
                <h4 class="heading-about">Sơ lược về {{ company()->company_brand }}</h4>
                <hr class="border-warning">
                <p><span class="font-weight-bold">Tên công ty: </span>{{ company()->company_name ?? 'Chưa cập nhật' }}</p>
                <p><span class="font-weight-bold">Tên quốc tế: </span>{{ company()->international_name ?? 'Chưa cập nhật' }}</p>
                <p><span class="font-weight-bold">Ngày thành lập: </span>{{ optional(company()->established_date)->format('d/m/Y') ?? 'Chưa cập nhật' }}</p>
                <p><span class="font-weight-bold">Mã số thuế: </span>{{ company()->tax_code ?? 'Chưa cập nhật' }}</p>
                <p><span class="font-weight-bold">Người đại diện: </span>{{ company()->director ?? 'Chưa cập nhật' }}</p>
            </div>

            {{-- Lịch sử hình thành --}}
            <div class="col-md-12 about-content" data-aos="fade-right">
                <h4 class="heading-about">{{ $page->title_2 }}</h4>
                <hr class="border-warning">
                <p>{!! $page->custom_content_2 !!}</p>
            </div>

            {{-- Chứng chỉ --}}
            <div class="col-md-12 about-content" data-aos="fade-right">
                <h4 class="heading-about">Chứng chỉ hoạt động</h4>
                <hr class="border-warning">
                @if(!empty(company()->certificates))
                    <div class="row justify-content-center">
                        @foreach(company()->certificates as $img)
                            <div class="col-md-4 text-center">
                                <div class="certificate-box mb-3">
                                    <img src="{{ $img }}" alt="certificate" class="img-fluid rounded shadow-sm">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Chưa cập nhật chứng chỉ</p>
                @endif
            </div>
        </div>
    </div>
</section>

@include('customers.partials.anphu.solution')
@include('customers.partials.sign_up_1')
@include('customers.partials.anphu.demo_projects')
@include('customers.partials.anphu.partner')
@endsection
