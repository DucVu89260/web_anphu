{{-- portfolios/edit.blade.php --}}
@extends('admins.layouts.master')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Cập nhật Dự án</h4>
        <a href="{{ route('admin.portfolios.index') }}" class="btn btn-sm btn-primary">← Quản lý dự án</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <h5 for="name">Tên dự án</h5>
                    <p class="text-muted text-style: italic">(Tên dự án không chứa icon)</p>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $portfolio->name) }}" required>
                </div>

                <div class="form-group">
                    <h5 for="location">Địa điểm</h5>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $portfolio->location) }}">
                </div>

                <div class="form-group">
                    <h5 for="location">Diện tích m2 (nếu có)</h5>
                    <input type="text" name="area" id="area" class="form-control" value="{{ old('area', $portfolio->area) }}">
                </div>

                <div class="form-group">
                    <h5 for="location">Số tầng (nếu có)</h5>
                    <input type="text" name="story" id="story" class="form-control" value="{{ old('story', $portfolio->story) }}">
                </div>

                <div class="form-group">
                    <h5 for="client">Khách hàng</h5>
                    <input type="text" name="client" id="client" class="form-control" value="{{ old('client', $portfolio->client) }}">
                </div>

                <div class="form-group">
                    <h5>Ảnh đại diện hiện tại</h5><br>
                        @if ($portfolio->thumbnail)
                            <img src="{{ $portfolio->thumbnail }}" alt="{{ $portfolio->name }}" width="100" class="img-thumbnail">
                        @else
                            <p class="text-muted">Không có ảnh</p>
                        @endif
                </div>

                <div class="form-group">
                    <h5 for="thumbnail">Thay ảnh đại diện (tùy chọn)</h5>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control-file">
                </div>

                <div class="form-group">
                    <h5 for="description">Mô tả</h5>
                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        class="form-control"
                    >{{ old('description', $portfolio->description) }}</textarea>
                </div>

                <div class="form-group">
                    <h5 for="year">Năm thực hiện</h5>
                    <input type="number" name="year" id="year" class="form-control" value="{{ old('year', $portfolio->year) }}">
                </div>

                <input type="hidden" name="type" value="portfolio">

                <x-category-select 
                    label="Loại hình công trình"
                    :categories="$categories"
                    :selected="$portfolio->category_id"
                    :useOptgroup="true"
                    class="form-control select2"
                />

                {{-- Component Quill --}}
                <div class="form-group">
                    <h5 for="content">Nội dung chi tiết</h5>
                    <p claas="text-muted">(Video hợp lệ để nhúng: Youtube, Facebook, Tiktok)</p>
                    <x-editor 
                        selector="#quill-editor"
                        uploadTable="portfolios"
                        toolbar="full"
                        height="500px"
                        placeholder="Nhập nội dung mô tả chi tiết..."
                        :uploadRoute="route('admin.media.uploadImage')"
                        :content="old('content', $portfolio->content ?? '')"
                        textareaName="content"
                    />
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-warning font-weight-bold">Cập nhật dự án</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection