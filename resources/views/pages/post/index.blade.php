@extends('layouts.main')
@section('title', 'Quản lý bài viết')
@section('page-title', 'Quản lý bài viết')
@section('content')
    <div class="card card-flush p-4">
        <div class="row d-flex justify-content-between">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">
                    <h1>
                        Danh sách bài viết
                    </h1>
                    <a class="mx-2" href="{{ route('admin.post.list') }}">
                        <span role="button" data-bs-toggle="tooltip" title="Tải lại trang "
                            class="refresh-btn svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Update.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </a>

                    <a class="mx-2" href="{{ route('admin.post.list.soft.deletes', 'post_soft_delete=1') }}">

                        <span data-bs-toggle="tooltip" title="Kho lưu trữ bản xóa "
                            class=" svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Files/Deleted-folder.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M10.5857864,14 L9.17157288,12.5857864 C8.78104858,12.1952621 8.78104858,11.5620972 9.17157288,11.1715729 C9.56209717,10.7810486 10.1952621,10.7810486 10.5857864,11.1715729 L12,12.5857864 L13.4142136,11.1715729 C13.8047379,10.7810486 14.4379028,10.7810486 14.8284271,11.1715729 C15.2189514,11.5620972 15.2189514,12.1952621 14.8284271,12.5857864 L13.4142136,14 L14.8284271,15.4142136 C15.2189514,15.8047379 15.2189514,16.4379028 14.8284271,16.8284271 C14.4379028,17.2189514 13.8047379,17.2189514 13.4142136,16.8284271 L12,15.4142136 L10.5857864,16.8284271 C10.1952621,17.2189514 9.56209717,17.2189514 9.17157288,16.8284271 C8.78104858,16.4379028 8.78104858,15.8047379 9.17157288,15.4142136 L10.5857864,14 Z"
                                        fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </a>

                </div>

            </div>
            <div class="col">
                <div class=" d-flex flex-row justify-content-end bd-highlight">
                    <a href="{{ route('admin.post.create') }}" class=" btn btn-primary">Tạo mới bài viết
                    </a>
                    <a href="{{ route('admin.post.insert') }}" class=" btn btn-outline-primary">Tạo mới bài viết bên ngoài
                    </a>
                </div>
            </div>
        </div>
        <div class="row card-format">
            {{-- <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="form-group p-2">
                    <label class="form-label">Doanh nghiệp tuyển dụng </label>
                    <select id="selectEnterprise" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="false" tabindex="-1" aria-hidden="true">
                        <option value="">Chọn doanh nghiệp</option>
                        @foreach ($enterprises as $enterprise)
                            <option @selected(request('enterprise_id') == $enterprise->id) value="{{ $enterprise->id }}">
                                {{ $enterprise->name }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div> --}}
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="  form-group pt-2">
                    <label class="form-label">Tìm kiếm </label>
                    <input id="searchTeam" value="{{ request('keyword') ?? '' }}" type="text"
                        placeholder="'*Enter' tìm kiếm ..." class=" ip-search form-control">
                </div>
            </div>
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="form-group  pt-2">
                    <label for="" class="form-label">Cơ sở đăng bài</label>
                    <select id="select-branch" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option class="form-control" value="">Chọn cơ sở</option>
                        @foreach ($branches as $branch)
                            <option @selected(request('branch_id') == $branch->id) value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="form-group  pt-2">
                    <label for="" class="form-label">Quá trình </label>
                    <select class="select-date-time form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option class="form-control" value="">Chọn hoạt động</option>
                        <option class="form-control" @selected(request('progress') == 'unpublished') value="unpublished"> Chưa xuất bản
                        </option>
                        <option class="form-control" @selected(request('progress') == 'published') value="published"> đã xuất bản
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="form-group  pt-2">
                    <label class="form-label">Tình trạng </label>
                    <select id="select-status" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="" @selected(!request()->has('status'))>Chọn tình trạng</option>
                        <option @selected(request('status') == 1) value="1">Kích họat
                        </option>
                        <option @selected(request()->has('status') && request('status') == 0) value="0">Không kích hoạt
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="  form-group pt-2">
                    <div class="mb-0">
                        <label class="form-label">Thời gian xuất bản </label>
                        <div id="reportrange"
                            style="background: #fff; cursor: pointer; padding: 10px 10px; border: 1px solid #e4e6ef ; width: 100%; border-radius: 7px">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="form-group  pt-2">
                    <label for="" class="form-label">Bài viết nổi bật</label>
                    <select class="select-filter-post-hot form-select mb-2 select2-hidden-accessible"
                        data-control="select2" data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option class="form-control" value="">Chọn loại bài viết</option>
                        <option class="form-control" @selected(request('postHot') == 'hot') value="hot">Bài viết nổi bật.
                        </option>
                        <option class="form-control" @selected(request('postHot') == 'normal') value="normal"> Bài viết thường .
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-12 row">
                <label class="form-label" for="">Lọc theo thành phần</label>
                <div class="row col-12 m-auto">
                    <button type="button"
                        class="click-recruitment  btn {{ request()->has('recruitment_id') || ($postable && $postable == 'recruitment') ? 'btn-primary' : '' }} col btn-light">
                        Bài viết thuộc tuyển dụng</button>
                    <button id="clickContset" type="button"
                        class="mygroup btn  {{ request()->has('contest_id') ? 'btn-primary' : '' }} col btn-light click-contest">
                        Bài viết thuộc cuộc thi</button>
                    <button id="clickCapacity" type="button"
                        class="mygroup btn  {{ request()->has('capacity_id') ? 'btn-primary' : '' }} col btn-light click-capacity">
                        Bài viết thuộc bài test</button>
                    <button type="button"
                        class="mygroup btn {{ request()->has('round_id') ? 'btn-primary' : '' }} col btn-light click-round">
                        Bài viết thuộc vòng thi</button>
                    <button type="button"
                        class="click-event  btn {{($postable && $postable == 'event') ? 'btn-primary' : '' }} col btn-light">
                        Bài viết thuộc tin tức-sự kiện</button>
                </div>
                <br>
                <div class="col-12 pb-2">
                    <div style="{{ request()->has('contest_id') ? '' : 'display: none' }}" id="contest">
                        <div class="form-group mb-10">
                            <label for="" class="form-label">Cuộc thi</label>
                            <select id="select-contest" name="contest_id" class="form-select form-contest"
                                data-control="select2" data-placeholder="Chọn cuộc thi ">
                                <option value="0">Chọn cuộc thi</option>
                                @foreach ($contest as $item)
                                    <option @selected(request('contest_id') == $item->id) value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                    </div>
                    <div style="{{ request()->has('capacity_id') ? '' : 'display: none' }}" id="capacity">
                        <div class="form-group mb-10">
                            <label for="" class="form-label">Cuộc thi</label>
                            <select id="select-capacity" name="capacity_id" class="form-select form-contest"
                                data-control="select2" data-placeholder="Chọn bài test ">
                                <option value="0">Chọn bài test</option>
                                @foreach ($capacity as $item)
                                    <option @selected(request('capacity_id') == $item->id) value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                    </div>
                    <div style="{{ request()->has('round_id') ? '' : 'display: none' }}" id="round">
                        <label class="form-label">Cuộc thi </label>
                        <select id="select-contest-p" class="form-select form-contest " data-control="select2"
                            data-placeholder="Chọn cuộc thi ">
                            <option value="">Chọn cuộc thi</option>
                            @foreach ($contest as $item)
                                <option @selected(($round ? $round->contest->id : 0) == $item->id) value="{{ $item->id }}">
                                    {{ $item->name }} - {{ count($item->rounds) }} vòng thi
                                </option>
                            @endforeach
                        </select>
                        <div>
                            <label class="form-label">Vòng thi </label>
                            <select id="select-round" name="round_id" class="form-select form-round "
                                data-control="select2" data-placeholder="Chọn vòng thi ">
                                @if (request()->has('round_id'))
                                    <option value="0">Chọn vòng thi</option>
                                    @foreach ($rounds as $r)
                                        @if (($round ? $round->contest->id : 0) == $r->contest_id)
                                            <option @selected(request('round_id') == $r->id) value="{{ $r->id }}">
                                                {{ $r->name }}

                                            </option>
                                        @endif
                                    @endforeach
                                @else
                                    <option disabled value="0">Không có vòng thi nào ! Hãy chọn cuộc thi </option>
                                @endif
                            </select>
                        </div>

                    </div>
{{--                    <div style="{{ request()->has('recruitment_id') ? '' : 'display: none' }}" id="recruitment">--}}
{{--                        <div class="form-group mb-10">--}}
{{--                            <label for="" class="form-label">Tuyển dụng</label>--}}
{{--                            <select id="select-recruitment" name="recruitment_id" class="form-select form-major"--}}
{{--                                data-control="select2" data-placeholder="Chọn cuộc thi ">--}}
{{--                                <option value="0">Chọn tuyển dụng</option>--}}
{{--                                @foreach ($recruitments as $item)--}}
{{--                                    <option @selected(request('recruitment_id') == $item->id) value="{{ $item->id }}">--}}
{{--                                        {{ $item->name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}

{{--                        </div>--}}

{{--                    </div>--}}
                </div>

            </div>

        </div>
        <div class="back">
            <hr>
            <span data-bs-toggle="tooltip" title="Đóng lọc" class="btn-hide svg-icon svg-icon-primary svg-icon-2x">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Stockholm-icons/Navigation/Angle-up.svg--><svg
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" />
                    </g>
                </svg>
            </span>

            <span data-bs-toggle="tooltip" title="Mở lọc" style="display: none"
                class="btn-show svg-icon svg-icon-primary svg-icon-2x">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) " />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>

        </div>
        <div class="table-responsive p-4 card card-flush ">

            @if (count($posts) > 0)
                <table class=" table table-hover table-responsive-md ">
                    <thead>
                        <tr>
                            {{-- <th scope="col">
                                <a
                                    href="{{ route('admin.post.list', [
                                        'sortBy' => request()->has('sortBy') ? (request('sortBy') == 'desc' ? 'asc' : 'desc') : 'asc',
                                        'orderBy' => 'id',
                                    ]) }}">
                                    <span role="button" data-key="id"
                                        class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            style="width: 14px !important ; height: 14px !important" width="24px"
                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                    x="5" y="5" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                    x="17" y="7" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) " />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </a>

                            </th> --}}
                            <th scope="col">Tiêu đề
                                <a
                                    href="{{ route('admin.post.list', [
                                        'sortBy' => request()->has('sortBy') ? (request('sortBy') == 'desc' ? 'asc' : 'desc') : 'asc',
                                        'orderBy' => 'title',
                                    ]) }}">
                                    <span role="button" data-key="name" data-bs-toggle="tooltip"
                                        title="Lọc theo tiêu đề bài viết "
                                        class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            style="width: 14px !important ; height: 14px !important" width="24px"
                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                    x="5" y="5" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                    x="17" y="7" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) " />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </a>

                            </th>
                            <th scope="col">Thuộc thành phần
                            </th>
                            <td></td>
                            <th scope="col">Trạng thái
                            </th>
                            <th scope="col">Nổi bật
                            </th>
                            <th scope="col">Đã ngừng tuyển
                            </th>
                            <th scope="col">Quá trình
                            </th>
                            <th scope="col">Ngày xuất bản
                                <a
                                    href="{{ route('admin.post.list', [
                                        'sortBy' => request()->has('sortBy') ? (request('sortBy') == 'desc' ? 'asc' : 'desc') : 'asc',
                                        'orderBy' => 'published_at',
                                    ]) }}">
                                    <span role="button" data-key="name" data-bs-toggle="tooltip"
                                        title="Lọc theo ngày xuất bản bài viết "
                                        class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            style="width: 14px !important ; height: 14px !important" width="24px"
                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                    x="5" y="5" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                    x="17" y="7" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) " />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </a>

                            </th>
                            <th scope="col">link ngoài
                            </th>
                            <th scope="col">Lượt xem
                            </th>
                            <th scope="col">Nội dung
                            </th>


                            <th class="text-center" colspan="2">

                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = $posts->total();
                        @endphp
                        @foreach ($posts as $index => $key)
                            <tr>
                                {{-- @if (request()->has('sortBy'))
                                    <th scope="row">
                                        @if (request('sortBy') == 'desc')
                                            {{ (request()->has('page') && request('page') !== 1 ? $posts->perPage() * (request('page') - 1) : 0) + $index + 1 }}
                                        @else
                                            {{ request()->has('page') && request('page') !== 1 ? $total - $posts->perPage() * (request('page') - 1) - $index : ($total -= 1) }}
                                        @endif
                                    </th>
                                @else
                                    <th scope="row">
                                        {{ (request()->has('page') && request('page') !== 1 ? $posts->perPage() * (request('page') - 1) : 0) + $index + 1 }}
                                    </th>
                                @endif --}}


                                <td>
                                    {{ $key->title }}
                                </td>
                                <td>
                                    @php
                                        $class = $key->postable ? get_class($key->postable) : $key->postable_type;
                                    @endphp
                                    @if ($class == \App\Models\Round::class)
                                        Vòng thi : <b><a
                                                href="{{ route('admin.round.detail', ['id' => $key->postable->id]) }}">{{ $key->postable->name }}
                                            </a></b>
                                    @elseif ($class == \App\Models\Recruitment::class)
                                        Tuyển dụng
                                        @if($key->postable)
                                            :
                                            <b><a
                                                    href="{{ route('admin.recruitment.detail', ['id' => $key->postable->id]) }}">{{ $key->postable->name }}</a></b>
                                        @endif
                                    @elseif($class == \App\Models\Contest::class && $key->status_capacity == 0)
                                        Cuộc thi : <b><a
                                                href="{{ route('admin.contest.show', ['id' => $key->postable->id]) }}">{{ $key->postable->name }}
                                            </a></b>
                                    @elseif($class == \App\Models\Event::class)
                                        Tin tức - sự kiện
                                    @else
                                        Bài test : <b><a
                                                href="{{ route('admin.contest.show.capatity', ['id' => $key->postable->id]) }}">{{ $key->postable->name }}</a></b>
                                    @endif
                                </td>
                                <td>
                                    @if ($class == \App\Models\Recruitment::class)
                                        <a href="{{ route('admin.candidate.list', ['post_id' => $key->id]) }}"
                                            class=" btn btn-primary btn-sm">Danh
                                            sách ứng tuyển
                                        </a>
                                    @endif
                                </td>

                                <td>
                                    @hasanyrole('admin|super admin')

                                        <div data-bs-toggle="tooltip" title="Cập nhật trạng thái "
                                            class="form-check form-switch">
                                            <input value="{{ $key->status }}" data-id="{{ $key->id }}"
                                                class="form-select-status form-check-input" @checked($key->status == 1)
                                                type="checkbox" role="switch">

                                        </div>
                                    @endhasrole

                                </td>
                                <td>
                                    @hasanyrole('admin|super admin')

                                        <div data-bs-toggle="tooltip" title="Cập nhật bài viết nổi bật "
                                            class="form-check form-switch">
                                            <input value="{{ $key->hot }}" data-id="{{ $key->id }}"
                                                class="form-select-post-hot form-check-input" @checked($key->hot == config('util.POST_HOT'))
                                                type="checkbox" role="switch">
                                        </div>
                                    @endhasrole

                                </td>
                                <td>
                                    @php
                                        $class = $key->postable ? get_class($key->postable) : $key->postable_type;
                                    @endphp
                                    @if($class == \App\Models\Recruitment::class)
                                        @hasanyrole('admin|super admin')
                                            <div data-bs-toggle="tooltip" title="Đã ngừng tuyển"
                                                class="form-check form-switch">
                                                <input value="{{ $key->full_recruitment }}" data-id="{{ $key->id }}"
                                                    class="form-select-full-recruitment form-check-input" @checked($key->full_recruitment == config('util.POST_FULL_RECRUITMENT'))
                                                    type="checkbox" role="switch">
                                            </div>
                                        @endhasrole
                                    @endif
                                </td>
                                <td>
                                    @if (\Carbon\Carbon::parse($key->published_at)->toDateTimeString() >
                                        \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString())
                                        <span class="badge bg-danger">Chưa xuất bản </span>
                                    @else
                                        <span class="badge  bg-success">Đã xuất bản </span>
                                    @endif
                                </td>
                                <td>
                                    {{ date('d-m-Y H:i', strtotime($key->published_at)) }}
                                    <br>
                                    {{ \Carbon\Carbon::parse($key->published_at)->diffforHumans() }}
                                </td>
                                <td>
                                    @if ($key->link_to != null)
                                        <a href="{{ $key->link_to }}" class="btn  btn-primary btn-sm">Xem</a>
                                    @endif
                                </td>
                                <td>
                                    {{ $key->view }}
                                </td>
                                <td>
                                    <button class="btn  btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#introduce_{{ $key->id }}">
                                        Xem
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="introduce_{{ $key->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Nội dung bài viết
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body  ">

                                                    @if (is_null($key->content))
                                                        <div class="col-md-3 mx-auto">
                                                            <a href="{{ $key->link_to }}">
                                                                <div
                                                                    class="badge badge-primary badge-pill bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                                                    <div class="m-0  ">
                                                                        <span class="text-white-700 fw-bold fs-6">Xem tại
                                                                            đây</span>
                                                                    </div>

                                                                </div>
                                                            </a>
                                                        </div>
                                                    @else
                                                        {!! $key->content !!}
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Thoát
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div data-bs-toggle="tooltip" title="Thao tác " class="btn-group dropstart">
                                        <button type="button" class="btn   btn-sm dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="svg-icon svg-icon-success svg-icon-2x">
                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Settings-2.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24"
                                                            height="24" />
                                                        <path
                                                            d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu  px-4 ">
                                            <li class="my-3">
                                                <a href="{{ route('admin.post.edit', $key->slug) }}">
                                                    <span role="button" class="svg-icon svg-icon-success svg-icon-2x">
                                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Design/Edit.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                                <rect fill="#000000" opacity="0.3" x="5"
                                                                    y="20" width="15" height="2"
                                                                    rx="1" />
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    Chỉnh sửa
                                                </a>
                                            </li>
                                            <li class="my-3">
                                                <a href="{{ route('admin.post.detail', $key->slug) }}">
                                                    <span class="svg-icon svg-icon-primary svg-icon-2x ">
                                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Text/Redo.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M21.4451171,17.7910156 C21.4451171,16.9707031 21.6208984,13.7333984 19.0671874,11.1650391 C17.3484374,9.43652344 14.7761718,9.13671875 11.6999999,9 L11.6999999,4.69307548 C11.6999999,4.27886191 11.3642135,3.94307548 10.9499999,3.94307548 C10.7636897,3.94307548 10.584049,4.01242035 10.4460626,4.13760526 L3.30599678,10.6152626 C2.99921905,10.8935795 2.976147,11.3678924 3.2544639,11.6746702 C3.26907199,11.6907721 3.28437331,11.7062312 3.30032452,11.7210037 L10.4403903,18.333467 C10.7442966,18.6149166 11.2188212,18.596712 11.5002708,18.2928057 C11.628669,18.1541628 11.6999999,17.9721616 11.6999999,17.7831961 L11.6999999,13.5 C13.6531249,13.5537109 15.0443703,13.6779456 16.3083984,14.0800781 C18.1284272,14.6590944 19.5349747,16.3018455 20.5280411,19.0083314 L20.5280247,19.0083374 C20.6363903,19.3036749 20.9175496,19.5 21.2321404,19.5 L21.4499999,19.5 C21.4499999,19.0068359 21.4451171,18.2255859 21.4451171,17.7910156 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(12.254964, 11.721538) scale(-1, 1) translate(-12.254964, -11.721538) " />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    Chi tiết
                                                </a>
                                            </li>
{{--                                            <li class="my-3">--}}
{{--                                                @hasrole('super admin')--}}
{{--                                                    @if ($key->postable?->count() == 0 && $key->user->count() == 0)--}}
{{--                                                        <form action="{{ route('admin.post.destroy', $key->slug) }}"--}}
{{--                                                            method="post">--}}
{{--                                                            @csrf--}}
{{--                                                            @method('delete')--}}
{{--                                                            <button onclick="return confirm('Bạn có chắc muốn xóa không !')"--}}
{{--                                                                style=" background: none ; border: none ; list-style : none"--}}
{{--                                                                type="submit">--}}
{{--                                                                <span role="button"--}}
{{--                                                                    class="svg-icon svg-icon-danger svg-icon-2x">--}}
{{--                                                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg--}}
{{--                                                                        xmlns="http://www.w3.org/2000/svg"--}}
{{--                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"--}}
{{--                                                                        width="24px" height="24px" viewBox="0 0 24 24"--}}
{{--                                                                        version="1.1">--}}
{{--                                                                        <g stroke="none" stroke-width="1" fill="none"--}}
{{--                                                                            fill-rule="evenodd">--}}
{{--                                                                            <rect x="0" y="0"--}}
{{--                                                                                width="24" height="24" />--}}
{{--                                                                            <path--}}
{{--                                                                                d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"--}}
{{--                                                                                fill="#000000" fill-rule="nonzero" />--}}
{{--                                                                            <path--}}
{{--                                                                                d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"--}}
{{--                                                                                fill="#000000" opacity="0.3" />--}}
{{--                                                                        </g>--}}
{{--                                                                    </svg>--}}
{{--                                                                    <!--end::Svg Icon-->--}}
{{--                                                                </span>--}}
{{--                                                                Xóa bỏ--}}
{{--                                                            </button>--}}
{{--                                                        </form>--}}
{{--                                                    @endif--}}
{{--                                                @else--}}
{{--                                                    <div style="cursor: not-allowed; user-select: none">--}}

{{--                                                        <span class="svg-icon svg-icon-danger svg-icon-2x">--}}
{{--                                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Lock-circle.svg--><svg--}}
{{--                                                                xmlns="http://www.w3.org/2000/svg"--}}
{{--                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"--}}
{{--                                                                height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--                                                                <g stroke="none" stroke-width="1" fill="none"--}}
{{--                                                                    fill-rule="evenodd">--}}
{{--                                                                    <rect x="0" y="0" width="24"--}}
{{--                                                                        height="24" />--}}
{{--                                                                    <circle fill="#000000" opacity="0.3" cx="12"--}}
{{--                                                                        cy="12" r="10" />--}}
{{--                                                                    <path--}}
{{--                                                                        d="M14.5,11 C15.0522847,11 15.5,11.4477153 15.5,12 L15.5,15 C15.5,15.5522847 15.0522847,16 14.5,16 L9.5,16 C8.94771525,16 8.5,15.5522847 8.5,15 L8.5,12 C8.5,11.4477153 8.94771525,11 9.5,11 L9.5,10.5 C9.5,9.11928813 10.6192881,8 12,8 C13.3807119,8 14.5,9.11928813 14.5,10.5 L14.5,11 Z M12,9 C11.1715729,9 10.5,9.67157288 10.5,10.5 L10.5,11 L13.5,11 L13.5,10.5 C13.5,9.67157288 12.8284271,9 12,9 Z"--}}
{{--                                                                        fill="#000000" />--}}
{{--                                                                </g>--}}
{{--                                                            </svg>--}}
{{--                                                            <!--end::Svg Icon-->--}}
{{--                                                        </span>--}}
{{--                                                        Xóa bỏ--}}
{{--                                                    </div>--}}
{{--                                                @endhasrole--}}

{{--                                            </li>--}}
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $posts->appends(request()->all())->links('pagination::bootstrap-4') }}
            @else
                <h2>Không tìm thấy bài viết !!!</h2>
            @endif

        </div>
    </div>
@endsection
@section('page-script')
    <script type="text/javascript" src="assets/js/custom/documentation/general/moment.min.js"></script>
    <script type="text/javascript" src="assets/js/custom/documentation/general/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="assets/js/system/post/postFilter.js"></script>
    <script>
        const _token = "{{ csrf_token() }}";
        const rounds = @json($rounds);
    </script>


    <script src="assets/js/system/formatlist/formatlis.js"></script>

@endsection
