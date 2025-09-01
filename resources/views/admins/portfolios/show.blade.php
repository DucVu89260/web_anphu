@extends('admins.layouts.master')

@php
    use Illuminate\Support\Str;
@endphp

@push('styles')
<style>
    .img-wrapper {
        width: 100%;
        height: 300px;
        overflow: hidden;
    }

    .img-wrapper img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .portfolio-content {
        padding: 0 1rem;
    }

    .portfolio-content img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 1rem auto;
        object-fit: contain;
        border-radius: 6px;
    }

    .portfolio-content p,
    .portfolio-content h1,
    .portfolio-content h2,
    .portfolio-content h3 {
        word-break: break-word;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<div class="container my-4">
    <h2 class="mb-3">{{ $portfolio->name }}</h2>

    <p class="text-muted small">
        Đăng ngày {{ $portfolio->created_at->format('d/m/Y') }}
    </p>

    {{-- Ảnh đại diện chính --}}
    @if ($portfolio->thumbnail)
        <div class="img-wrapper mb-4">
            <img src="{{ $portfolio->thumbnail }}" alt="{{ $portfolio->name }}">
        </div>
    @endif

    {{-- Nội dung mô tả --}}
    @if ($portfolio->description)
        <div class="mb-4">
            <p class="lead" style="white-space: pre-line;">{{ $portfolio->description }}</p>
        </div>
    @endif

    {{-- Nội dung chi tiết --}}
    <div class="portfolio-content">
        {!! $portfolio->content !!}
    </div>

    {{-- Gallery --}}
    @if ($portfolio->media->count())
        <div class="media-gallery mt-5">
            <div class="row">
                @foreach ($portfolio->media as $media)
                    <div class="col-md-4 mb-4 d-flex align-items-stretch">
                        <div class="card shadow-sm w-100">
                            @if(Str::contains($media->type, 'image'))
                                <div class="text-center p-2">
                                    <div class="img-wrapper bg-light border rounded overflow-hidden">
                                        <img src="{{ $media->file_path }}"
                                             class="img-fixed"
                                             alt="media">
                                    </div>
                                </div>
                            @elseif(Str::contains($media->type, 'youtube'))
                                <div class="youtube-video-wrapper mb-4">
                                    <iframe src="{{ $media->file_path }}"
                                            frameborder="0"
                                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            @endif

                            @if ($media->caption)
                                <div class="card-body p-2">
                                    <p class="card-text small text-muted">{{ $media->caption }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
