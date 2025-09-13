@extends('admins.layouts.master')

@section('content')
<div class="container my-4">
    <h4>Chỉnh sửa thông tin công ty</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('general_settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="company_name">Tên công ty</label>
            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $setting->company_name) }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $setting->email) }}">
        </div>

        <div class="form-group">
            <label for="company_phone">Số điện thoại</label>
            <input type="text" name="company_phone" class="form-control" value="{{ old('company_phone', $setting->company_phone) }}">
        </div>

        <div class="form-group">
            <label for="company_address">Địa chỉ</label>
            <textarea name="company_address" class="form-control">{{ old('company_address', $setting->company_address) }}</textarea>
        </div>

        <div class="form-group">
            <label for="policy">Chính sách</label>
            <textarea name="policy" class="form-control" rows="4">{{ old('policy', $setting->policy) }}</textarea>
        </div>

        <div class="form-group">
            <label for="pricing_note">Ghi chú giá cả</label>
            <textarea name="pricing_note" class="form-control" rows="4">{{ old('pricing_note', $setting->pricing_note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection