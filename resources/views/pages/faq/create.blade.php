@extends('layouts.main')
@section('title', 'Quản lý Q&A')
@section('page-title', 'Quản lý Q&A')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">

                    <a href="{{ route('admin.faq.list') }}" class="pe-3">
                        Danh sách Q&A
                    </a>

                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới câu hỏi</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formQA" action="{{ route('admin.faq.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Câu hỏi</label>
                                <textarea type="text" id="kt_docs_ckeditor_classic" name="question" class=" form-control"
                                    row="3"></textarea>
                                @error('question')
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
                                <label for="" class="form-label">Chủ đề</label>
                                <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="false" tabindex="-1" aria-hidden="true" name="type">
                                    <option value="" disabled>Chọn chủ đề</option>
                                    <option value="{{ config('util.FAQ.TYPE.INTERNSHIP') }}">Thực tập</option>
                                    <option value="{{ config('util.FAQ.TYPE.WORKING') }}">Việc làm</option>
                                    <option value="{{ config('util.FAQ.TYPE.EVENT') }}">Sự kiện</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-10">
                                <label class="form-label" for="">Câu trả lời</label>
                                <textarea type="text" id="kt_docs_ckeditor_classic2" name="answer" class=" form-control"
                                    row="3"></textarea>
                                @error('answer')
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
                        <button type="submit" id="buttonQA" class="btn btn-success btn-lg btn-block">Lưu </button>
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
    <script src="assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css" crossorigin>
    <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js" crossorigin></script>
    <script src="assets/js/system/ckeditor/ckeditorUploadImage.js"></script>
    <script src="{{ asset('assets/js/system/question-and-answer/validateForm.js') }}"></script>
    <script src="{{ asset('assets/js/system/validate/validate.js') }}"></script>
@endsection
