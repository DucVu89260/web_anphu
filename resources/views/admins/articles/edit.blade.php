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
               <h5 for="name">Tên bài đăng</h5>
               <p class="text-muted text-style: italic">(Tên bài đăng không chứa icon)</p>
               <input
                  type="text"
                  name="name"
                  id="name"
                  class="form-control"
                  value="{{ $article->name }}"
               >
            </div>

            <div class="form-group">
               <h5 for="description">Mô tả</h5>
               <textarea
                  name="description"
                  id="description"
                  rows="4"
                  class="form-control"
               >{{ old('description', $article->description) }}
               </textarea>
            </div>

            <!-- <div class="form-group"> -->
               <input
                  type="hidden"
                  name="link"
                  id="link"
                  value="{{ $article->link }}"
               >
            <!-- </div> -->

            <input type="hidden" name="type" value="article">

            <x-category-select 
               label="Danh mục bài đăng"
               :categories="$categories"
               :selected="$article->category_id"
               :useOptgroup="true"
               class="form-control select2"
            />

            <div class="form-group">
               <h5>Ảnh đại diện hiện tại</h5><br>
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
               <h5 for="content">Nội dung chi tiết</h5>.
               <p claas="text-muted">(Video hợp lệ để nhúng: Youtube, Facebook, Tiktok)</p>
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
