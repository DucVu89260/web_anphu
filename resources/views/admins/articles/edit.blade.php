@extends('admins.layouts.master')

@section('content')
<div class="container my-4">
   <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Cập nhật Bài Đăng</h4>
      <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-primary">← Quản lý Bài Đăng</a>
   </div>

   <div class="card shadow-sm">
      <div class="card-body">
         <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
               <label for="name">Tên bài đăng</label>
               <input
                  type="text"
                  name="name"
                  id="name"
                  class="form-control"
                  value="{{ $article->name }}"
               >
            </div>

            <div class="form-group">
               <label for="description">Mô tả</label>
               <textarea
                  name="description"
                  id="description"
                  rows="4"
                  class="form-control"
               >
                  {{ old('description', $article->description) }}
               </textarea>
            </div>

            <div class="form-group">
               <label for="link">Link</label>
               <input
                  type="text"
                  name="link"
                  id="link"
                  class="form-control"
                  value="{{ $article->link }}"
               >
            </div>

            <input type="hidden" name="type" value="article">

            <div class="form-group">
               <label for="category_id">Danh mục bài đăng</label>
               <select name="category_id" id="category_id" class="form-control select2">
                  <option value="">-- Chọn danh mục --</option>
                  @foreach ($categories as $cat)
                        {{-- Option cho cấp 1 --}}
                        <option value="{{ $cat->id }}"
                           {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>
                           {{ $cat->name }}
                        </option>

                        {{-- Nếu có cấp con, hiển thị thêm --}}
                        @if ($cat->children->isNotEmpty())
                           @foreach ($cat->children as $child)
                              <option value="{{ $child->id }}"
                                 {{ (old('category_id', $article->category_id) == $child->id) ? 'selected' : '' }}>
                                       {{ $child->name }}
                                 </option>
                           @endforeach
                        @endif
                  @endforeach
               </select>
            </div>

            <div class="form-group">
               <label>Ảnh đại diện hiện tại</label><br>
                  @if ($article->thumbnail)
                        <img
                           src="{{ $article->thumbnail }}"
                           alt="{{ $article->name }}"
                           width="100"
                           class="img-thumbnail"
                        >
                  @else
                        <p class="text-muted">Không có ảnh</p>
                  @endif
            </div>

            <div class="form-group">
               <label for="thumbnail">Thay ảnh đại diện (tùy chọn)</label>
               <input type="file" name="thumbnail" id="thumbnail" class="form-control-file">
            </div>

            {{-- Component Quill --}}
            <div class="form-group">
               <label for="content">Nội dung chi tiết</label>
               <x-editor 
                  selector="#quill-editor"
                  uploadTable="articles"
                  toolbar="full"
                  height="500px"
                  placeholder="Nhập nội dung mô tả chi tiết..."
                  :uploadRoute="route('admin.media.uploadImage')"
                  :content="old('content', $article->content ?? '')"
                  textareaName="content"
               />
            </div>

            <div class="text-right">
               <button type="submit" class="btn btn-warning font-weight-bold">Cập nhật bài đăng</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
