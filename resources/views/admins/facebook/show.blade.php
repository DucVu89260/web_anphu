@extends('admins.layouts.master')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Chi tiết bài đăng</h2>
    <hr class="border-warning">

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ $post['message'] ?? '[Không có nội dung]' }}</h5>
            <p class="text-muted">
                Đăng ngày: {{ \Carbon\Carbon::parse($post['created_time'])->format('d/m/Y H:i') }}
            </p>
            <a href="{{ $post['permalink_url'] }}" target="_blank" class="btn btn-sm btn-secondary mb-3">
                Xem trên Facebook
            </a>

            @if(!empty($media))
                <h6 class="mt-4">Media</h6>
                <div class="row">
                    @foreach($media as $item)
                        <div class="col-md-4 mb-3">
                            @if($item['type'] === 'image')
                                <img src="{{ $item['url'] }}" alt="Media" class="img-fluid" style="max-height: 200px; object-fit: cover;">
                            @elseif($item['type'] === 'video')
                                <video controls style="max-height: 200px;">
                                    <source src="{{ $item['url'] }}" type="video/mp4">
                                </video>
                            @else
                                <a href="{{ $item['url'] }}" target="_blank">Xem media</a>
                            @endif
                            <p class="small text-muted">Nguồn: {{ $item['source'] }}</p>
                            @if(!empty($item['title']))
                                <p class="small">Tiêu đề: {{ $item['title'] }}</p>
                            @endif
                            @if(!empty($item['description']))
                                <p class="small">Mô tả: {{ $item['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Không có media.</p>
            @endif
        </div>
    </div>
</div>
@endsection

