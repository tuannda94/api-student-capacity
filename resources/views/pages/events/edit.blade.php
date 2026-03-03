@extends('layouts.main')
@section('title', 'Quản lý sự kiện')
@section('page-title', 'Quản lý sự kiện')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.event.list') }}" class="pe-3">
                        Danh sách sự kiện
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới sự kiện</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formEvent" action="{{ route('admin.event.update', ['event'=> $event->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Tên sự kiện</label>
                                <input type="text" name="name" class=" form-control" value="{{ old('name', $event->name) }}"/>
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
                                <label class="form-label" for="">Mô tả</label>
                                <input type="text" name="description" class=" form-control" value="{{ old('description', $event->description) }}"/>
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
                                <label class="form-label" for="">Ảnh bìa</label>
                                <input name="thumbnail" type='file' id="file-input" class="form-control" />
                                <img class="mw-10 mt-4 border rounded-3" id="image-preview"
                                    src="{{ $event->thumbnail }}" />
                                @error('thumbnail')
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
                                <label for="" class="form-label">Thời gian bắt đầu</label>
                                <input type="datetime-local" name="start_at" class="form-control" value="{{ old('start_at', $event->start_at) }}">
                                @error('start_at')
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
                                <label for="" class="form-label">Thời gian kết thúc</label>
                                <input type="datetime-local" name="end_at" class="form-control" value="{{ old('end_at', $event->end_at) }}">
                                @error('end_at')
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
                                    <option @selected($event->status == config('util.ACTIVE_STATUS')) value="{{config('util.ACTIVE_STATUS')}}">Active</option>
                                    <option @selected($event->status == config('util.INACTIVE_STATUS')) value="{{config('util.INACTIVE_STATUS')}}">Inactive</option>
                                </select>
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
