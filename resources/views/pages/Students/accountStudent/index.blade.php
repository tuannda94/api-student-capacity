@extends('layouts.main')
@section('title', 'Quản lý tài khoản ')
@section('page-title', 'Quản lý tài khoản ')
@section('content')

    <div class="card card-flush p-4">
        <div>
            <div class="alert alert-primary">
                Xin chào {{ auth()->user()->name }} , bạn thuộc quyền
                {{ \Str::ucfirst(auth()->user()->roles[0]->name) }}
                cơ sở {{ auth()->user()->campus->name }}
                <span data-bs-toggle="tooltip" title="Tải lại trang " role="button"
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
            </div>
        </div>

        <div class="row card-format">
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="form-group">
                    <label class="form-label">Tình trạng </label>
                    <select id="select-status" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                            data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="3" @selected(!request()->has('status'))>Chọn tình trạng</option>
                        <option @selected(request('status') == 1) value="1">Kích hoạt
                        </option>
                        <option @selected(request()->has('status') && request('status') == 0) value="0">Không kích hoạt
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="  form-group">
                    <label class="form-label">Tìm kiếm </label>
                    <input type="text" value="{{ request('q') ?? '' }}" placeholder="*Enter tìm kiếm ..."
                           class=" ip-search form-control">
                </div>
            </div>

        </div>

        <div>
            <div class="back">

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

                <span data-bs-toggle="tooltip" title="Mở lọc" class="btn-show svg-icon svg-icon-primary svg-icon-2x">
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
        </div>


        <div class="table-responsive table-responsive-md">
            <table class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                <thead>
                <tr>
                    <th>
                        STT
                    </th>
                    <th>
                        Mã Sinh viên
                    </th>
                    <th>
                        Tên tài khoản
                    </th>
                    <th>
                        Email
                    </th>
                    <th>Tình trạng </th>
                    <th>Lựa chọn</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $key => $user)
                    <tr>
                        <td>
                            {{ $key+1}}
                        </td>
                        <td>
                            {{ $user->mssv != null ? $user->mssv : 'Chưa có mã sinh viên' }}
                        </td>
                        <td>
                            {{ $user->name}}
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>
                        {{-- @if (count($user->roles) > 0) --}}
                        <td>
                            @if (auth()->user()->roles[0]->name == 'super admin')
                                @if (auth()->user()->id == $user->id)
                                    <span class="svg-icon svg-icon-primary svg-icon-2x">
                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Stop.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path
                                                        d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M12,20 C16.418278,20 20,16.418278 20,12 C20,7.581722 16.418278,4 12,4 C7.581722,4 4,7.581722 4,12 C4,16.418278 7.581722,20 12,20 Z M19.0710678,4.92893219 L19.0710678,4.92893219 C19.4615921,5.31945648 19.4615921,5.95262146 19.0710678,6.34314575 L6.34314575,19.0710678 C5.95262146,19.4615921 5.31945648,19.4615921 4.92893219,19.0710678 L4.92893219,19.0710678 C4.5384079,18.6805435 4.5384079,18.0473785 4.92893219,17.6568542 L17.6568542,4.92893219 C18.0473785,4.5384079 18.6805435,4.5384079 19.0710678,4.92893219 Z"
                                                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                </g>
                                            </svg>
                                        <!--end::Svg Icon-->
                                        </span>
                                    {{ $user->status == 1 ? 'Hoạt động ' : 'Đã gỡ ' }}
                                @else
                                    <div data-bs-toggle="tooltip" title="Cập nhật trạng thái "
                                         class="form-check form-switch">
                                        <input value="{{ $user->status }}" data-id="{{ $user->id }}"
                                               class="form-select-status form-check-input" @checked($user->status == 1)
                                               type="checkbox" role="switch">
                                    </div>
                                @endif
                            @else
                                @if (auth()->user()->roles[0]->name == 'admin')
                                    @if ($user->roles[0]->name == 'super admin' || auth()->user()->id == $user->id)
                                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Stop.svg--><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                       fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24"
                                                              height="24" />
                                                        <path
                                                            d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M12,20 C16.418278,20 20,16.418278 20,12 C20,7.581722 16.418278,4 12,4 C7.581722,4 4,7.581722 4,12 C4,16.418278 7.581722,20 12,20 Z M19.0710678,4.92893219 L19.0710678,4.92893219 C19.4615921,5.31945648 19.4615921,5.95262146 19.0710678,6.34314575 L6.34314575,19.0710678 C5.95262146,19.4615921 5.31945648,19.4615921 4.92893219,19.0710678 L4.92893219,19.0710678 C4.5384079,18.6805435 4.5384079,18.0473785 4.92893219,17.6568542 L17.6568542,4.92893219 C18.0473785,4.5384079 18.6805435,4.5384079 19.0710678,4.92893219 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            <!--end::Svg Icon-->
                                            </span>
                                        {{ $user->status == 1 ? 'Hoạt động ' : 'Đã gỡ ' }}
                                    @else
                                        <div data-bs-toggle="tooltip" title="Cập nhât trạng thái "
                                             class="form-check form-switch">
                                            <input value="{{ $user->status }}" data-id="{{ $user->id }}"
                                                   class="form-select-status form-check-input"
                                                   @checked($user->status == 1) type="checkbox" role="switch">
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </td>
                        <td >
                            <a href="{{ route('manage.student.view',$user->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="800px" width="800px" version="1.1" id="Layer_1" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
<path d="M469.3,362.7H42.7C19.1,362.7,0,381.8,0,405.3V448c0,23.5,19.1,42.7,42.7,42.7h426.7c23.5,0,42.7-19.1,42.7-42.7v-42.7  C512,381.8,492.9,362.7,469.3,362.7z M85.3,448H42.7v-42.7h42.7V448z M384,448h-21.3v-42.7H384V448z M426.7,448h-21.3v-42.7h21.3  V448z M469.3,448H448v-42.7h21.3V448z M469.3,192H42.7C19.1,192,0,211.1,0,234.7v42.7C0,300.9,19.1,320,42.7,320h426.7  c23.5,0,42.7-19.1,42.7-42.7v-42.7C512,211.1,492.9,192,469.3,192z M85.3,277.3H42.7v-42.7h42.7V277.3z M384,277.3h-21.3v-42.7H384  V277.3z M426.7,277.3h-21.3v-42.7h21.3V277.3z M469.3,277.3H448v-42.7h21.3V277.3z M469.3,21.3H42.7C19.1,21.3,0,40.5,0,64v42.7  c0,23.5,19.1,42.7,42.7,42.7h426.7c23.5,0,42.7-19.1,42.7-42.7V64C512,40.5,492.9,21.3,469.3,21.3z M85.3,106.7H42.7V64h42.7V106.7z   M384,106.7h-21.3V64H384V106.7z M426.7,106.7h-21.3V64h21.3V106.7z M469.3,106.7H448V64h21.3V106.7z"/>
</svg>                       </a>

{{--                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="800px" height="800px" viewBox="0 0 256 256" id="Flat">--}}
{{--                                    <g opacity="0.2">--}}
{{--                                        <path d="M192,120,136,64l26.34315-26.34315a8,8,0,0,1,11.3137,0l44.6863,44.6863a8,8,0,0,1,0,11.3137Z"/>--}}
{{--                                    </g>--}}
{{--                                    <path d="M216,208H115.314l82.33838-82.33887.00489-.00439.00439-.00488L223.999,99.31445A15.99888,15.99888,0,0,0,224,76.68652L179.31348,31.999A16.02162,16.02162,0,0,0,156.68555,32l-120,120.00049a15.95392,15.95392,0,0,0-3.572,5.45654c-.08228.19971-.15162.40283-.21705.60742A15.9896,15.9896,0,0,0,32,163.31348V208a16.01833,16.01833,0,0,0,16,16H216a8,8,0,0,0,0-16ZM51.314,160l84.6858-84.686L180.68579,120,96,204.68652ZM168,43.31348,212.68555,88,192,108.68555,147.314,64ZM48,179.314,76.686,208H48Z"/>--}}
{{--                                </svg>--}}
{{--                            </a>--}}

{{--                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none"><path d="M4.99997 8H6.5M6.5 8V18C6.5 19.1046 7.39543 20 8.5 20H15.5C16.6046 20 17.5 19.1046 17.5 18V8M6.5 8H17.5M17.5 8H19M9 5H15M9.99997 11.5V16.5M14 11.5V16.5" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/></svg>   </a>--}}
                        </td>
                        {{-- @else --}}
                        {{-- <td>Không có quyền !</td> --}}
                        {{-- <td>Không có quyền !</td> --}}
                        {{-- @endif --}}
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            {{ $users->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>

    </div>


@endsection
@section('page-script')
    <script>
        let url = "/admin/accountStudent?";
        const _token = "{{ csrf_token() }}";
        const sort = '{{ request()->has('sort') ? (request('sort') == 'desc' ? 'asc' : 'desc') : 'asc' }}';
        const start_time =
            '{{ request()->has('start_time') ? \Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const end_time =
            '{{ request()->has('end_time') ? \Carbon\Carbon::parse(request('end_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
    </script>
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script src="assets/js/system/auth/auth.js"></script>
@endsection
