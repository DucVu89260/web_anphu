@extends('admins.layouts.master')

@push('styles')
<style>
    .filter-facebook {
        min-width: 200px;
        max-width: 290px;
        padding: 0.5rem 1rem;
        border: 2px solid var(--color-primary);
        border-radius: 8px;
        background-color: #fff;
        font-weight: 600;
        text-align: left;
        color: var(--color-dark);
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        appearance: none;
        background-repeat: no-repeat;
        background-size: 14px;
    }

    .filter-facebook:hover {
        background-color: var(--color-gray);
        color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .filter-facebook:focus {
        outline: none;
        border-color: var(--color-secondary);
        box-shadow: 0 0 0 0.25rem rgba(0,123,255,0.25);
    }

</style>
@endpush

@section('content')
<div class="container">
    <div class="mb-4 text-center" style="margin-top: 10px;">
        <h2 class="text-primary fw-bold mb-2">
            Bài đăng Facebook: An Phú Build ({{ $filtered_count }}/{{ $total_count }})
        </h2>
        <hr class="border-warning">
    </div>
    <hr class="mb-4">
    <h4 class="mb-4 text-center">Tìm kiếm theo</h4>    
    <div class="mb-4 text-center">
        {{-- Form lọc --}}
        <form method="GET" action="{{ route('admin.facebook.index') }}" id="filterForm" class="mb-4">
            <div class="row g-2 justify-content-center">
                <div class="col-auto">
                    <select name="status" class="filter-facebook form-select shadow-sm border-primary fw-semibold"
                            onchange="document.getElementById('filterForm').submit();">
                        <option value="">Tất cả bài đăng An Phú Build</option>
                        <option value="article" {{ request('status') == 'article' ? 'selected' : '' }}>
                            📄 Đã lưu vào Bài đăng
                        </option>
                        <option value="portfolio" {{ request('status') == 'portfolio' ? 'selected' : '' }}>
                            🏗️ Đã lưu vào Dự án
                        </option>
                        <option value="unsaved" {{ request('status') == 'unsaved' ? 'selected' : '' }}>
                            ⏳ Chưa lưu
                        </option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border border-2 h-100">
                    
                    {{-- Ảnh --}}
                    @if(!empty($post['full_picture']))
                        <img src="{{ $post['full_picture'] }}" 
                             alt="Post Image" 
                             class="card-img-top"
                             style="max-height: 250px; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        {{-- Nội dung rút gọn với scroll --}}
                        <div class="mb-3" style="max-height: 100px; overflow-y: auto;">
                            <p class="card-text">{{ $post['message'] ?? '[Không có nội dung]' }}</p>
                        </div>

                        <small class="text-muted mb-3">
                            {{ \Carbon\Carbon::parse($post['created_time'])->format('d/m/Y H:i') }}
                        </small>

                        {{-- Trạng thái lưu --}}
                        @if(isset($savedFbMap[$post['id']]))
                            @if($savedFbMap[$post['id']] === 'article')
                                <span class="badge bg-success align-self-start mb-3">Đã lưu vào Bài Đăng</span>
                            @elseif($savedFbMap[$post['id']] === 'portfolio')
                                <span class="badge bg-info align-self-start mb-3">Đã lưu vào Dự Án</span>
                            @endif
                        @else
                            <span class="badge bg-secondary align-self-start mb-3">Chưa lưu về website</span>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <a href="{{ $post['permalink_url'] }}" target="_blank" 
                            class="btn btn-sm btn-secondary px-3">
                                Trên Facebook
                            </a>

                            {{-- Nút lưu vào DB --}}
                            <div class="dropdown">
                                <button class="btn btn-sm btn-success dropdown-toggle px-3" type="button" data-toggle="dropdown">
                                    Lưu về Website
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    {{-- Lưu Article --}}
                                    <form action="{{ route('admin.facebook.edit', $post['id']) }}" method="GET" class="m-0">
                                        <input type="hidden" name="type" value="article">
                                        <button type="submit" class="dropdown-item">Lưu vào Bài Đăng</button>
                                    </form>

                                    {{-- Lưu Portfolio --}}
                                    <form action="{{ route('admin.facebook.edit', $post['id']) }}" method="GET" class="m-0">
                                        <input type="hidden" name="type" value="portfolio">
                                        <button type="submit" class="dropdown-item">Lưu vào Dự Án</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-between">
        @if($has_previous)
            <a href="{{ route('admin.facebook.index', ['before' => $cursors['before']]) }}" class="btn btn-outline-primary px-4"><</a>
        @else
            <span></span>
        @endif

        @if($has_next)
            <a href="{{ route('admin.facebook.index', ['after' => $cursors['after']]) }}" class="btn btn-outline-primary px-4">></a>
        @endif
    </div>
</div>
@endsection
