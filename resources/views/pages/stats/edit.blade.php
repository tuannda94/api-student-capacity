@extends('layouts.main')
@section('title', 'Quản lý thông số')
@section('page-title', 'Quản lý thông số')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.stat.list') }}" class="pe-3">
                        Danh sách thông số
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Chỉnh sửa thông số</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formStat" action="{{ route('admin.stat.update', ['stat'=> $stat->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên thông số</label>
                                <input type="text" name="name" class=" form-control" value="{{ old('name', $stat->name) }}"/>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Trạng thái</label>
                                <select name="status" class="form-control mb-2" >
                                    <option @selected($stat->status == config('util.ACTIVE_STATUS')) value="{{config('util.ACTIVE_STATUS')}}">Active</option>
                                    <option @selected($stat->status == config('util.INACTIVE_STATUS')) value="{{config('util.INACTIVE_STATUS')}}">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Ảnh bìa</label>
                                <input name="icon" type='file' id="file-input" class="form-control" />
                                <img class="mt-4 border rounded-3" style="max-height:50px" id="image-preview"
                                    src="{{ $stat->icon }}" />
                                @error('icon')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Giá trị</label>
                                <input type="number" name="value" class=" form-control" value="{{ old('value', $stat->value) }}"/>
                                @error('value')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Đơn vị</label>
                                <input type="text" name="unit" class=" form-control" value="{{ old('unit', $stat->unit) }}"/>
                                @error('unit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if (session()->has('errorName'))
                                    <p class="text-danger">{{ session()->get('errorName') }}</p>
                                    @php
                                        Session::forget('errorName');
                                    @endphp
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-10 ">
                        <button type="submit" id="buttonQA" class="btn btn-success btn-lg btn-block">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session()->has('userArray'))
        @php
            $userArray = session()->get('userArray');
            Session::forget('userArray');
        @endphp
    @endif
@endsection
@section('page-script')
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script>
        preview.showFile('#file-input', '#image-preview');
    </script>
@endsection
