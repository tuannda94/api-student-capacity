let selectBlocks = document.getElementById("blocks");
let selectSubject = document.getElementById("subjects");
let classSubjectSelect = document.getElementById("classSubject");
let DataResult = {};
function eventSubject(btn,htmlimport){
    btn.addEventListener("change", function() {
        var idSemeter = btn.value;
        DataResult.semeter = idSemeter;
        if(idSemeter != ""){
            $.ajax({
                url: `/admin/accountStudent/GetBlock/${idSemeter}`,
                type: 'GET',
                success: function(response) {
                    console.log( response.data);
                    let html = '<option value="">-- Chọn Block--</option>';
                    // console.log(response.data)
                    //insert data vào
                    if(response.data != ""){
                        html += response.data.map((value)=>{
                            DataResult.nameBlock = value.name
                            return `<option value="${value.id}">${value.name}</option>`
                        }).join(' ')
                    }else  {
                        html += '<option value="">Không có dữ liệu</option>'
                    }
                    selectBlocks = document.getElementById("blocks");
                    htmlimport.innerHTML = html;
                },
                error: function(response) {
                    console.log(response);
                    // Xử lý lỗi
                }
            });
        }else  {

            notify('Tải dữ liệu không thành công !')
        }

    });
}
eventSubject(selectSemeter,selectBlocks);
selectBlocks.addEventListener("change", function() {
    var idblock = selectBlocks.value;
    DataResult.block = idblock;
    var selectedOption = selectBlocks.options[selectBlocks.selectedIndex];
    DataResult.nameBlock  = selectedOption.text;
    if(idblock != ""){
        $.ajax({
            url: `/admin/accountStudent/GetSubject/${idblock}`,
            type: 'GET',
            success: function(response) {
                console.log( response.data);
                let html = '<option value="">-- Chọn Môn --</option>';
                // console.log(response.data)
                //insert data vào
                if(response.data != ""){
                    html += response.data.map((value)=>{
                        return `<option value="${value.id}">${value.name}</option>`
                    }).join(' ')
                }else  {
                    html += '<option value="">Không có dữ liệu</option>'
                }

                selectSubject.innerHTML = html;
                selectSubject = document.getElementById("subjects");
            },
            error: function(response) {

                console.log(response);
                // Xử lý lỗi
            }
        });
    }else  {
        selectSubject.innerHTML = '<option value="">-- Chọn Môn --</option><option value="">Không có dữ liệu</option>'
        notify('Tải dữ liệu không thành công !')
    }

});
selectSubject.addEventListener("change", function() {
    var idSubject = selectSubject.value;
    DataResult.subject = idSubject;
});
var chart1 = null; // Biến lưu trữ đối tượng biểu đồ
function chartRender(category,tookExam,notExam,total){
    var element1 = document.getElementById('kt_apexcharts_2');

    var height = parseInt(KTUtil.css(element, 'height'));
    var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
    var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
    var baseColor = KTUtil.getCssVariableValue('--bs-success');
    var secondaryColor = KTUtil.getCssVariableValue('--bs-danger');
    var memecondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');
    if (!element) {
        return;
    }

    var options1 = {
        series: [{
            name: 'Sinh viên đã thi',
            data: notExam
        }, {
            name: 'Sinh viên chưa thi',
            data: tookExam
        }, {
            name: 'Tổng sinh viên',
            data: total
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
            categories: category,
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
                    return  val + ' sinh viên'
                }
            }
        },
        colors: [baseColor, secondaryColor,memecondaryColor],
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
    // Kiểm tra và hủy biểu đồ cũ nếu tồn tại
    if (chart1) {
        chart1.destroy();
    }
    chart1 = new ApexCharts(element1, options1);
    chart1.render();
}
const search = document.getElementById('searchResult');
search.addEventListener('click',() => {
    console.log(DataResult);
    if (
        "semeter" in DataResult &&
        "block" in DataResult &&
        "subject" in DataResult
    ) {
        // Kiểm tra giá trị của từng thuộc tính
        if (
            DataResult.semeter &&
            DataResult.block &&
            DataResult.subject
        ) {
            $.ajax({
                url: `/admin/chart/GetPoetryDetail`,
                type: 'POST',
                data : DataResult,
                success: function(response) {
                    console.log( response.data);
                    wanrning('Vui lòng chờ ...')
                    chartRender(response.data.namePoetry,response.data.student.tookExam,response.data.student.notExam,response.data.student.total);
                },
                error: function(response) {

                    console.log(response);
                }
            });

        } else {
            errors("Vui lòng chọn đủ các thông tin");
        }
    } else {
        console.log(DataResult)
        errors("Vui lòng chọn đủ môn và bộ môn cần tra cứu");
    }
})
