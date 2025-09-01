@extends('admins.layouts.master')

@section('content')
<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Cài đặt danh mục</h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Thêm danh mục</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Bộ lọc -->
    <form method="GET" action="{{ route('admin.categories.index') }}" class="col-md-2 mb-2">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <select name="type" class="form-select">
                    <option value="">-- Tất cả loại --</option>
                    <option value="portfolio" {{ request('type') == 'portfolio' ? 'selected' : '' }}>
                        Dự án
                    </option>
                    <option value="article" {{ request('type') == 'article' ? 'selected' : '' }}>
                        Bài đăng
                    </option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-secondary">Lọc</button>
            </div>
        </div>
    </form>
    <hr>
    <h5>Danh sách danh mục</h5>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Loại</th>
                <th>Danh mục cha</th>
                <th width="150">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $parent)
                @php
                    $rowClass = '';
                    if ($parent->type->value === 'article') {
                        $rowClass = 'table-success'; // Article = xanh lá
                    } elseif ($parent->type->value === 'portfolio') {
                        $rowClass = 'table-warning'; // Portfolio = vàng
                    }
                @endphp

                <tr class="{{ $rowClass }} font-weight-bold">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $parent->name }}</td>
                    <td>{{ $parent->slug }}</td>
                    <td>{{ $parent->type->label() ?? '-' }}</td>
                    <td>—</td>
                    <td>
                        <a
                            href="{{ route('admin.categories.edit', $parent) }}"
                            class="btn btn-sm btn-warning"
                        >
                            Sửa
                        </a>
                        <form
                            method="POST"
                            action="{{ route('admin.categories.destroy', $parent) }}"
                            class="d-inline"
                            onsubmit="return confirm('Xóa danh mục này?')"
                        >
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>

                @foreach ($parent->children as $child)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            ↳
                            {{ $child->name }}
                        </td>
                        <td>{{ $child->slug }}</td>
                        <td>{{ $child->type->value ?? '-' }}</td>
                        <td>{{ $parent->name }}</td>
                        <td>
                            <a
                                href="{{ route('admin.categories.edit', $child) }}"
                                class="btn btn-sm btn-warning"
                            >
                                Sửa
                            </a>
                            <form
                                method="POST"
                                action="{{ route('admin.categories.destroy', $child) }}"
                                class="d-inline"
                                onsubmit="return confirm('Xóa danh mục này?')"
                            >
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            @empty
                <tr>
                    <td colspan="7" class="text-center">Không có danh mục nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center">
        {{ $categories->links() }}
    </div>

</div>
@endsection
