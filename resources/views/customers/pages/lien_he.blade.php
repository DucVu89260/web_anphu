@extends('customers.layouts.master')

@push('styles')
<style>
    :root {
        --lux-dark: #0b1c2c;
        --lux-dark-2: #081420;
        --lux-text-light: #f5f2e7;
        --anphu-gold: #d6aa3a;
        --anphu-gold-2: #d4a537;

    }

    .section-bg-contact {
        background-color: var(--lux-dark);
        background-image:
            linear-gradient(rgba(11, 28, 44, 0.85), rgba(11, 28, 44, 0.85)),
            url('/assets/img/gallery/background_danmask_1.jpg');
        background-position: center;
        background-repeat: repeat;
        background-size: auto;
        background-attachment: fixed;
        position: relative;
        border-bottom: 2px solid var(--anphu-gold);
        width: 100%;
    }

    .lux-map-title {
        color: var(--anphu-gold);
        border-left: 4px solid var(--anphu-gold);
        padding-left: 10px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    /* Tiêu đề vàng luxury */
    .heading-contact {
        text-align: center;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        background: linear-gradient(90deg, var(--anphu-gold), var(--anphu-gold-2));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .heading-contact-2 {
        text-align: center;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        background: linear-gradient(90deg, #d6aa3a, #d4a537);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        text-shadow: 0 0 10px rgba(201,176,55,0.6);
    }

    /* Nội dung chính */
    .contact-content {
        color: var(--lux-text-light);
        padding: 2rem;
        text-align: center;
        border-radius: 20px;
    }

    /* Nội dung phụ chia 2 cột */
    .contact-extra-content h3 {
        background: linear-gradient(90deg, var(--anphu-gold), var(--anphu-gold-2));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
        text-transform: uppercase;
        text-align: center;
    }
    .contact-extra-content {
        background-color: rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 15px;
        color: var(--lux-text-light);
    }

    .card-blog {
        border: 1px solid #C9B037;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        min-height: 250px;
        transition: transform 0.3s ease;
    }
    .card-blog:hover {
        transform: translateY(-4px);
    }

    .blog-overlay {
        background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.7));
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        border: 1px solid var(--lux-text-light);
    }
    .blog-overlay h5 {
        color: var(--anphu-gold);
    }
    .blog-overlay p {
        color: var(--lux-text-light);
    }
    
    /* Carousel */
    .contact-carousel {
        width: 100vw;
    }
    .contact-carousel .carousel-item {
        height: 60vh;
    }
    .contact-carousel .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 1px solid var(--anphu-gold);
    }

    /* Responsive fix */
    @media (max-width: 767.98px) {
        .contact-content,
        .contact-extra-content {
            padding: 1rem;
        }
    }

    /* Carousel indicators tụt hẳn xuống dưới */
    .carousel-indicators.custom-indicators {
        position: absolute;
        bottom: -48px; /* -25px trước + -30px nữa = -55px */
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        padding-left: 0;
        margin: 0;
        list-style: none;
        z-index: 10;
    }

    .carousel-indicators.custom-indicators li {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        margin: 0 6px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .carousel-indicators.custom-indicators li.active,
    .carousel-indicators.custom-indicators li:hover {
        background-color: var(--anphu-gold);
        transform: scale(1.2);
    }

    /* Hiệu ứng slide ảnh nhẹ */
    .carousel-inner .carousel-item {
        transition: transform 0.8s ease, opacity 0.8s ease;
    }

</style>
@endpush

@section('content')

<section class="py-5 section-bg-contact">

    <h4 class="heading-contact">Liên hệ với chúng tôi</h4>

    @php
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $page->custom_content_1 ?? '', $matches);
        $images = array_unique($matches[1] ?? []); // loại bỏ ảnh trùng
    @endphp

    @if(count($images) > 0)
        <div id="contactImageCarousel" class="carousel slide contact-carousel mb-4" data-ride="carousel">
            <div class="carousel-inner">
                @foreach($images as $index => $img)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ $img }}" alt="Slide {{ $index + 1 }}">
                    </div>
                @endforeach
            </div>

            {{-- 3 chấm dưới carousel --}}
            <ol class="carousel-indicators custom-indicators">
                @foreach($images as $index => $img)
                    <li data-target="#contactImageCarousel" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>

            <a class="carousel-control-prev" href="#contactImageCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#contactImageCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>
    @else
        <p class="text-center">Chưa có hình ảnh liên hệ nào.</p>
    @endif
    
    <hr>

    <div class="container">
        {{-- PHẦN MAP --}}
        <div class="mb-5">
            <h5 class="lux-map-title">Bản Đồ</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="embed-responsive embed-responsive-4by3 border rounded">
                        <iframe
                            src="{{ company()->google_map['embed_url'] ?? '' }}"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="embed-responsive embed-responsive-4by3 border rounded">
                        <iframe
                            src="{{ company()->google_map_2['embed_url'] ?? '' }}"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        {{-- FORM ĐĂNG KÝ --}}
        <div class="mt-5">
            <h5 class="lux-map-title">Đăng ký ngay để nhận ưu đãi</h5>
            @include('customers.partials.sign_up_2')
        </div>

    </div>
</section>

<section class="py-5 section-bg-contact">
    <div class="container">
        <div class="row contact-content">
            {{-- SƠ LƯỢC --}}
            <div class="col-md-12" data-aos="fade-right">
                <h2 class="heading-contact">{{ $page->title_2 }}</h2>
                {!! $page->custom_content_2 !!}
            </div>
        </div>
        <div class="row mt-4 contact-extra-content" data-aos="fade-up">
            <!-- Cột trái -->
            <div class="col-md-6">
                <h3 class="mb-3">Dự án thi công</h3>
                @foreach ($congTrinhArticles as $article)
                    <div class="col-md-12 mb-4 blog-item">
                        <a href="{{ route('customers.blog.detail', $article->slug) }}" class="text-decoration-none">
                            <div class="card card-blog"
                                style="background-image: url('{{ $article->thumbnail }}'); background-size: cover; background-position: center;">
                                <div class="blog-overlay p-3">
                                    <h5 class="font-weight-bold">{{ $article->name }}</h5>

                                    @if (!empty($article->category))
                                        <p class="mb-0 font-weight-bold">Chủ đề: {{ $article->category->name }}</p>
                                    @endif

                                    @if (!empty($article->category))
                                        <p class="mb-0 font-weight-bold small">
                                            Đăng ngày {{ $article->created_at->format('d/m/Y') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- Cột phải -->
            <div class="col-md-6">
                <h3 class="mb-3">Cảm nhận khách hàng</h3>
                @foreach ($camNhanArticles as $article)
                    <div class="col-md-12 mb-4 blog-item">
                        <a href="{{ route('customers.blog.detail', $article->slug) }}" class="text-decoration-none">
                            <div class="card card-blog"
                                style="background-image: url('{{ $article->thumbnail }}'); background-size: cover; background-position: center;">
                                <div class="blog-overlay p-3">
                                    <h5 class="font-weight-bold">{{ $article->name }}</h5>

                                    @if (!empty($article->category))
                                        <p class="mb-0 font-weight-bold">Chủ đề: {{ $article->category->name }}</p>
                                    @endif

                                    @if (!empty($article->category))
                                        <p class="mb-0 font-weight-bold small">
                                            Đăng ngày {{ $article->created_at->format('d/m/Y') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </section>


@include('customers.partials.anphu.demo_projects')
@include('customers.partials.anphu.partner')

@endsection