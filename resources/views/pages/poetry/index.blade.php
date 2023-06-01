@extends('layouts.main')
@section('title', 'Quản lý ca thi')
@section('page-title', 'Quản lý ca thi')
@section('content')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->

            <div class="card card-flush p-4">
                <div class="row">
                    <div class=" col-lg-6">

                        <h1>
                            Danh sách ca thi
                        </h1>
                    </div>
                    <div class=" col-lg-6">
                        <div class=" d-flex flex-row-reverse bd-highlight">
                            <label data-bs-toggle="modal" data-bs-target="#kt_modal_1" type="button"
                                   class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">

                                <!--end::Svg Icon-->Thêm ca thi
                            </label>
                        </div>
                    </div>
                </div>




                <div class="table-responsive table-responsive-md">
                    <table id="table-data" class="table table-row-bordered table-row-gray-300 gy-7  table-hover ">
                        <thead>
                        <tr>
                            <th scope="col">Tên học kỳ
                                <span role="button" data-key="name" data-bs-toggle="tooltip" title="" class=" svg-icon svg-icon-primary  svg-icon-2x format-database" data-bs-original-title="Lọc theo tên đánh giá năng lực">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 14px !important ; height: 14px !important" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <rect fill="#000000" opacity="0.3" transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) " x="5" y="5" width="2" height="12" rx="1"></rect>
                                        <path d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z" fill="#000000" fill-rule="nonzero"></path>
                                        <rect fill="#000000" opacity="0.3" transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) " x="17" y="7" width="2" height="12" rx="1"></rect>
                                        <path d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z" fill="#000000" fill-rule="nonzero" transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) "></path>
                                    </g>
                                </svg>
                                    <!--end::Svg Icon-->
                            </span>
                            </th>
                            <th scope="col">Môn học</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian bắt đầu
                                <span role="button" data-key="date_start" data-bs-toggle="tooltip" title="" class=" svg-icon svg-icon-primary  svg-icon-2x format-database" data-bs-original-title="Lọc theo thời gian bắt đầu ">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 14px !important ; height: 14px !important" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <rect fill="#000000" opacity="0.3" transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) " x="5" y="5" width="2" height="12" rx="1"></rect>
                                        <path d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z" fill="#000000" fill-rule="nonzero"></path>
                                        <rect fill="#000000" opacity="0.3" transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) " x="17" y="7" width="2" height="12" rx="1"></rect>
                                        <path d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z" fill="#000000" fill-rule="nonzero" transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) "></path>
                                    </g>
                                </svg>
                                    <!--end::Svg Icon-->
                            </span>
                            </th>
                            <th scope="col">Thời gian kết thúc
                                <span role="button" data-key="register_deadline" data-bs-toggle="tooltip" title="" class=" svg-icon svg-icon-primary  svg-icon-2x format-database" data-bs-original-title="Lọc theo thời gian kết thúc ">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 14px !important ; height: 14px !important" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <rect fill="#000000" opacity="0.3" transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) " x="5" y="5" width="2" height="12" rx="1"></rect>
                                        <path d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z" fill="#000000" fill-rule="nonzero"></path>
                                        <rect fill="#000000" opacity="0.3" transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) " x="17" y="7" width="2" height="12" rx="1"></rect>
                                        <path d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z" fill="#000000" fill-rule="nonzero" transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) "></path>
                                    </g>
                                </svg>
                                    <!--end::Svg Icon-->
                            </span>
                            </th>
                            <th colspan="2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($poetry) > 0)
                        @foreach($poetry as $key => $value)
                            <tr>
                                <td>
                                    {{ $value->semeter->name }}
                                </td>
                                <td>
                                    {{ $value->subject->name }}
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" data-id="{{ $value->id }}" type="checkbox" {{ $value->status == 1 ? 'checked' : '' }} role="switch" id="flexSwitchCheckDefault">
                                    </div>
                                </td>
                                <td>{{ $value->start_time == null ? 'Chưa có thời gian bắt đầu' :    date('d-m-Y', strtotime($value->start_time)) 	 }}</td>
                                <td>{{ $value->end_time == null ? 'Chưa có thời gian kết thúc' :   date('d-m-Y', strtotime($value->end_time)) }}</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
                                        <!--end::Svg Icon--></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <button  class="menu-link px-3 border border-0 bg-transparent" onclick="location.href='{{ route('admin.poetry.manage.index',$value->id) }}'"   type="button">
                                                Chi tiết
                                            </button>
                                        </div>
                                        <div class="menu-item px-3">
                                            <button  class="btn-edit menu-link px-3 border border-0 bg-transparent"  data-id="{{ $value->id }}" data-semeter="{{ $value->id_semeter }}">
                                                Chỉnh sửa
                                            </button>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <button href="#"  class="btn-delete menu-link border border-0 bg-transparent" data-id="{{ $value->id }}" data-kt-users-table-filter="delete_row">Delete</button>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>




                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="4">
                                    <h1 class="text-center">Không có ca thi nào</h1>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            {{ $poetry->links() }}
                        </ul>
                    </nav>

                </div>
            </div>

            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    {{--    form add--}}
    <div class="modal fade" tabindex="-1" id="kt_modal_1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm mới ca thi</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="form-submit" action="{{ route('admin.poetry.create') }}" >
                    @csrf
                    <div class="form-group m-10">
                        <select class="form-select" name="semeter" id="semeter_id">
                            <option selected value="">--Chọn kỳ học--</option>
                            @foreach($semeter as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="subject" id="subject_id" style="display:none;">

                        </select>
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="status" id="status_add">
                            <option selected value="">Trạng thái</option>
                            <option value="1">Kích hoạt</option>
                            <option value="0">Chưa kích hoạt</option>
                        </select>
                    </div>
                    <div class="form-group m-10">
                        <label for="" class="form-label">Thời gian bắt đầu</label>
                        <input type="date" name="start_time" id="start_time" class=" form-control"
                        >
                    </div>
                    <div class="form-group m-10">
                        <label for="" class="form-label">Thời gian kết thúc</label>
                        <input type="date" name="end_time" id="end_time" class=" form-control"
                        >
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="upload-basis" class=" btn btn-primary">Tải lên </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--    form sửa--}}
    <div class="modal fade" tabindex="-1" id="edit_modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa Kỳ học</h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="form-update"  >
                    @csrf
                    <input type="hidden" name="id_update" id="id_update">
                    <div class="form-group m-10">
                        <label for="" class="form-label">Kỳ học</label>
                    <select class="form-select" name="semeter" id="semeter_id_update">
                        <option selected value="">--Chọn kỳ học--</option>
                        @foreach($semeter as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="subject" id="subject_id_update" >

                        </select>
                    </div>
                    <div class="form-group m-10">
                        <select class="form-select" name="status" id="status_update">
                            <option selected value="">Trạng thái</option>
                            <option value="1">Kích hoạt</option>
                            <option value="0">Chưa kích hoạt</option>
                        </select>
                    </div>
                    <div class="form-group m-10">
                        <label for="" class="form-label">Thời gian bắt đầu</label>
                        <input type="date" name="start_time" id="start_time_update" class=" form-control"
                        >
                    </div>
                    <div class="form-group m-10">
                        <label for="" class="form-label">Thời gian kết thúc</label>
                        <input type="date" name="end_time" id="end_time_update" class=" form-control"
                        >
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-update" class=" btn btn-primary">Tải lên </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        function notify(message) {
            new Notify({
                status: 'success',
                title: 'Thành công',
                text: `${message}`,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'right top'
            })
        }
        function wanrning(message) {
            new Notify({
                status: 'warning',
                title: 'Đang chạy',
                text: `${message}`,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'right top'
            })
        }
        function errors(message) {
            new Notify({
                status: 'error',
                title: 'Lỗi',
                text: `${message}`,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'right top'
            })
        }
        function formatDate(DateValue){

            var date = new Date(DateValue);

            var day = date.getDate();
            var month = date.getMonth() + 1; // Ghi chú: Tháng bắt đầu từ 0 (0 = tháng 1)
            var year = date.getFullYear();

            const formattedDate = day + "-" + month + "-" + year;
            return formattedDate;
        }
        const table = document.querySelectorAll('#table-data tbody tr');
        let STT = parseInt(table[table.length - 1].childNodes[1].innerText) + 1;
        let btnDelete = document.querySelectorAll('.btn-delete');
        let btnEdit = document.querySelectorAll('.btn-edit');
        let btnUpdate = document.querySelector('#btn-update');
        const _token = "{{ csrf_token() }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="{{ asset('assets/js/system/poetry/poetry.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    {{--    Thêm --}}
    <script>
        $('#upload-basis').click(function (e){
            e.preventDefault();
            var url = $('#form-submit').attr("action");
            var semeter_id = $('#semeter_id').val();
            var subject_id = $('#subject_id').val();
            var status = $('#status_add').val();
            var start_time_semeter = $('#start_time').val();
            var end_time_semeter = $('#end_time').val();
            var dataAll = {
                '_token' : _token,
                'semeter_id' : semeter_id,
                'subject_id' : subject_id,
                'status' : status,
                'start_time_semeter' : start_time_semeter,
                'end_time_semeter' : end_time_semeter,
            }
            $.ajax({
                type:'POST',
                url: url,
                data: dataAll,
                success: (response) => {
                    console.log(response)
                    $('#form-submit')[0].reset();
                    notify(response.message);
   //                  var newRow = ` <tr>
   //                              <td>
   //                                  ${response.data.name_semeter}
   //                  </td>
   // <td>
   //                                  ${response.data.name_subject}
   //                  </td>
   //                  <td>
   //                      <div class="form-check form-switch">
   //                          <input class="form-check-input" data-id="${response.data.id}" type="checkbox" ${response.data.status == 1 ? 'checked' : ''} role="switch" id="flexSwitchCheckDefault">
   //                                  </div>
   //                              </td>
   //                              <td>${  formatDate(response.data.start_time) }</td>
   //                              <td>${ formatDate(response.data.end_time)}</td>
   //           <td class="text-end">
   //                                  <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
   //                                      <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
   //                                      <span class="svg-icon svg-icon-5 m-0">
	// 														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
	// 															<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
	// 														</svg>
	// 													</span>
   //                                      <!--end::Svg Icon--></a>
   //                                  <!--begin::Menu-->
   //                                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="">
   //                                      <!--begin::Menu item-->
   //                                      <div class="menu-item px-3">
   //                                          <button  class="menu-link px-3 border border-0 bg-transparent" onclick="location.href='#'"   type="button">
   //                                              Chi tiết
   //                                          </button>
   //                                      </div>
   //                                      <div class="menu-item px-3">
   //                                          <button  class="btn-edit menu-link px-3 border border-0 bg-transparent"  data-id="${response.data.id}" data-semeter="#">
   //                                              Chỉnh sửa
   //                                          </button>
   //                                      </div>
   //                                      <!--end::Menu item-->
   //                                      <!--begin::Menu item-->
   //                                      <div class="menu-item px-3">
   //                                          <button href="#"  class="btn-delete menu-link border border-0 bg-transparent" data-id="${response.data.id}" data-kt-users-table-filter="delete_row">Delete</button>
   //                                      </div>
   //                                      <!--end::Menu item-->
   //                                  </div>
   //                                  <!--end::Menu-->
   //                              </td>
   //
   //                          </tr>
   //                  `;
   //
   //                  $('#table-data tbody').append(newRow);
   //                  btnEdit = document.querySelectorAll('.btn-edit');
   //                  update(btnEdit)
   //                  btnDelete = document.querySelectorAll('.btn-delete');
   //                  dele(btnDelete)
                    $('#kt_modal_1').modal('hide');
                },
                error: function(response){
                    // console.log(response.responseText)
                    errors(response.responseText);
                    // $('#ajax-form').find(".print-error-msg").find("ul").html('');
                    // $('#ajax-form').find(".print-error-msg").css('display','block');
                    // $.each( response.responseJSON.errors, function( key, value ) {
                    //     $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    // });

                }
            });

        })
    </script>
    {{--    Sửa --}}
    <script>
        update(btnEdit)
        function update(btns){
            for (const btnupdate of btns) {
                btnupdate.addEventListener('click',() => {
                    const id = btnupdate.getAttribute("data-id");
                    const id_semeter = btnupdate.getAttribute("data-semeter");
                    $.ajax({
                        url: `/admin/poetry/edit/${id_semeter}/${id}`,
                        type: 'GET',
                        success: function(response) {
                            console.log(response);
                            notify('Tải dữ liệu thành công !')
                            $('#semeter_id_update').val(response.data.poetry.id_semeter);
                            const selectSubject = document.getElementById("subject_id_update");
                            let html = "";
                            const btnEnvent = document.getElementById("semeter_id_update");
                            if(response.data.subject.length > 0){
                                html = response.data.subject.map((value)=>{
                                    return `<option value="${value.id}" ${response.data.poetry.id_subject == value.id ? 'selected' : ''} >${value.name}</option>`
                                }).join(' ')
                            }else {
                                html = '<option value="">Không có data</option>';
                            }
                            selectSubject.innerHTML = html
                            eventSubject(btnEnvent,selectSubject)
                            // $('#subject_id_update').val(response.data.id_subject);

                            $('#status_update').val(response.data.poetry.status);
                            $('#id_update').val(response.data.poetry.id)
                            const date_start = moment(response.data.poetry.start_time ).format("YYYY-MM-DD");
                            $('#start_time_update').val(date_start)
                            const date_end = moment(response.data.poetry.end_time).format("YYYY-MM-DD");
                            $('#end_time_update').val(date_end)
                            // Gán các giá trị dữ liệu lấy được vào các trường tương ứng trong modal
                            $('#edit_modal').modal('show');
                        },
                        error: function(response) {
                            console.log(response);
                            // Xử lý lỗi
                        }
                    });
                })
            }
        }
        onupdate(btnUpdate)
        function onupdate(btn){
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                var semeter_id_update = $('#semeter_id_update').val();
                var subject_id_update = $('#subject_id_update').val();
                var status_update = $('#status_update').val();
                var id = $('#id_update').val();

                const date_start = $('#start_time_update').val();
                const date_end = $('#end_time_update').val();
                var dataAll = {
                    '_token' : _token,
                    'semeter_id_update' : semeter_id_update,
                    'subject_id_update' : subject_id_update,
                    'status_update' : status_update,
                    'start_time_semeter' : date_start,
                    'end_time_semeter' : date_end
                }
                $.ajax({
                    type:'PUT',
                    url: `admin/poetry/update/${id}`,
                    data: dataAll,
                    success: (response) => {
                        console.log(response)
                        $('#form-submit')[0].reset();
                        notify(response.message);
                        const idup =  `data-id='${response.data.id}'`;
                        // console.log(idup);
                        var buttons = document.querySelector('button.btn-edit['+idup+']');
                        const elembtn = buttons.parentNode.parentNode.parentNode.parentNode.childNodes ;
                        // console.log(elembtn)
                        elembtn[1].innerText = response.data.name_semeter;
                        elembtn[3].innerText = response.data.name_subject;
                        const output = response.data.status_update == 1 ? true : false;
                        // console.log(elembtn[5].childNodes[1].childNodes[1]);
                        elembtn[5].childNodes[1].childNodes[1].checked= output
                        elembtn[7].innerText =  response.data.start_time_semeter;
                        elembtn[9].innerText =  response.data.end_time_semeter;

                        btnEdit = document.querySelectorAll('.btn-edit');
                        update(btnEdit)
                        btnDelete = document.querySelectorAll('.btn-delete');
                        dele(btnDelete)
                        $('#edit_modal').modal('hide');
                    },
                    error: function(response){
                        // console.log(response.responseText)
                        errors(response.responseText);
                        // $('#ajax-form').find(".print-error-msg").find("ul").html('');
                        // $('#ajax-form').find(".print-error-msg").css('display','block');
                        // $.each( response.responseJSON.errors, function( key, value ) {
                        //     $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        // });

                    }
                });
            })
        }
    </script>
    {{--    Xóa --}}
    <script>
        dele(btnDelete);
        function dele(btns){
            for (const btnDeleteElement of btns) {
                btnDeleteElement.addEventListener("click",() => {
                    const id = btnDeleteElement.getAttribute("data-id");
                    console.log(id)
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Bạn có chắc chắn muốn xóa không!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var data = {
                                '_token' : _token
                            }
                            $.ajax({
                                type:'DELETE',
                                url: `admin/poetry/delete/${id}`,
                                data: data,
                                success: (response) => {
                                    console.log(response)
                                    Swal.fire(
                                        'Deleted!',
                                        `${response.message}`,
                                        'success'
                                    )
                                    const elm =  btnDeleteElement.parentNode.parentNode;
                                    var seconds = 2000/1000;
                                    elm.style.transition = "opacity "+seconds+"s ease";
                                    elm.style.opacity = 0;
                                    setTimeout(function() {
                                        elm.remove()
                                    }, 2000);
                                },
                                error: function(response){
                                    // console.log(response.responseText)
                                    errors(response.responseText);
                                    // $('#ajax-form').find(".print-error-msg").find("ul").html('');
                                    // $('#ajax-form').find(".print-error-msg").css('display','block');
                                    // $.each( response.responseJSON.errors, function( key, value ) {
                                    //     $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                                    // });

                                }
                            });

                        }
                    })
                })
            }
        }

    </script>

    {{--    Cập nhật trang thái nhanh--}}

@endsection
