@extends('layouts.main')
@section('title', 'Thống kê')
@section('page-title', 'Thống kê')
@section('content')
{{--    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>--}}
{{--    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>--}}
{{--    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>--}}
{{--    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>--}}
{{--    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>--}}
{{--    <!-- CSS -->--}}
<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
<script src="assets/plugins/global/plugins.bundle.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css"/>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">

            <div class="card card-flush p-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê block</h3>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-body">
                                <div id="kt_apexcharts_1" style="height: 350px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-4">
                    <div class="col-4">
                        <select class="form-select"  id="semeters">
                            <option value="0">--Chọn Kỳ--</option>
                            @foreach($semeters as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <select class="form-select" id="blocks">
                            <option>-- Chọn Block --</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <select class="form-select" id="subjects">
                            <option>-- Chọn Môn --</option>
                        </select>
                    </div>
{{--                    <div class="col-3">--}}
{{--                        <select class="form-select" id="classSubject">--}}
{{--                            <option>Lớp học</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
                </div>
                <div class="row">
                    <div class="col-2 my-4 mx-auto">
                        <button type="button" class="btn btn-primary er fs-6 px-8 py-4" id="searchResult">Tra cứu</button>
                    </div>
                </div>
                <div class="row">
                   <div class="col-12">
                       <div class="card-header">
                           <h3 class="card-title">Thống kê sinh viên theo lớp - môn</h3>
                       </div>
                       <div class="card card-bordered">
                           <div class="card-body">
                               <div id="kt_apexcharts_2" style="height: 350px;"></div>
                           </div>
                       </div>
                   </div>
                </div>
{{--                <div class="row">--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="card card-p-0 card-flush">--}}
{{--                            <div class="card-body">--}}
{{--                                <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="table-data">--}}
{{--                                    <thead>--}}
{{--                                    <!--begin::Table row-->--}}
{{--                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase">--}}
{{--                                        <th class="min-w-100px">Kỳ học</th>--}}
{{--                                        <th class="min-w-100px">Block</th>--}}
{{--                                        <th class="min-w-100px">Môn</th>--}}
{{--                                        <th class="min-w-100px">Lớp</th>--}}
{{--                                        <th class="text-end min-w-75px">Ca Học</th>--}}
{{--                                        <th class="text-end min-w-100px pe-5">Action</th>--}}
{{--                                    </tr>--}}
{{--                                    <!--end::Table row-->--}}
{{--                                    </thead>--}}
{{--                                    <tbody class="fw-bold text-gray-600">--}}
{{--                                                                    <tr >--}}
{{--                                                                        <td>--}}
{{--                                                                            <a href="#" class="text-dark text-hover-primary">Summer 2023</a>--}}
{{--                                                                        </td>--}}
{{--                                                                        <td>--}}
{{--                                                                            <a href="#" class="text-dark text-hover-primary">Block 1</a>--}}
{{--                                                                        </td>--}}
{{--                                                                        <td>--}}
{{--                                                                            <div class="badge badge-light-success">Môn Toán</div>--}}
{{--                                                                        </td>--}}
{{--                                                                        <td data-order="2022-03-10T14:40:00+05:00">VIE1026.06</td>--}}
{{--                                                                        <td class="text-end pe-0">Ca 3</td>--}}
{{--                                                                        <td class="text-end"><button class="btn btn-primary er fs-6 px-4 py-2">Xem Thêm</button></td>--}}
{{--                                                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}


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
        const _token = "{{ csrf_token() }}";
        let selectSemeter = document.querySelector('#semeters');
    </script>
    <script src="{{ asset('assets/js/system/chart/chart.js') }}"></script>
    @php
        $dataChart = json_encode($dataChart);
    @endphp
    <script>
        let datachart = {!! $dataChart !!};
        // console.log(datachart);
        var element = document.getElementById('kt_apexcharts_1');

        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        var baseColor = KTUtil.getCssVariableValue('--bs-warning');
        var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');

        // if (!element) {
        //     return;
        // }

        var options = {
            series: [{
                name: 'Số ca thi',
                data: datachart.total_poetry
            }],
            chart: {
                fontFamily: 'inherit',
                type: 'bar',
                height: height,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    columnWidth: ['30%'],
                    endingShape: 'rounded'
                },
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: datachart.nameBlock,
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px'
                },
                y: {
                    formatter: function (val) {
                        return val + ' ca thi'
                    }
                }
            },
            colors: [baseColor, secondaryColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    </script>
@endsection

