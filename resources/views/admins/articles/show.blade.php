@extends('admins.layouts.master')

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

    .article-content {
        padding: 0 1rem;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 1rem auto;
        object-fit: contain;
        border-radius: 6px;
    }

    .article-content p, 
    .article-content h1, 
    .article-content h2, 
    .article-content h3 {
        word-break: break-word;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<div class="container my-4">
    <h2 class="mb-3">{{ $article->name }}</h2>

    <p class="text-muted small">
        Đăng ngày {{ $article->created_at->format('d/m/Y') }}
    </p>

    <div class="article-content mb-4">
        {!! $article->content !!}
    </div>

    @if ($article->media->count())
        <div class="media-gallery">
            <div class="row">
                @foreach ($article->media as $media)
                    <div class="col-md-4 mb-4 d-flex align-items-stretch">
                        <div class="card shadow-sm w-100">
                            @if(Str::contains($media->type, 'image'))
                                <div class="text-center p-2">
                                    <div class="img-wrapper bg-light border rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . $media->file_path) }}"
                                            class="img-fixed"
                                            alt="media">
                                    </div>
                                </div>
                            @elseif(Str::contains($media->type, 'youtube'))
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="{{ $media->file_path }}" allowfullscreen></iframe>
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
