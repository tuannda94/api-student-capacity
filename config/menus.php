<?php
$ROLE_HAS_ADMINS = 'admin|super admin';
$ROLE_JUDGE = 'admin|super admin|judge|teacher';
$TYPE_CAPACITY = 1;
return [
    [
        "icon" => '
        <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
        <span class="svg-icon svg-icon-primary svg-icon-2x">
            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Question-circle.svg--><svg
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24" />
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12"
                        r="10" />
                    <path
                        d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z"
                        fill="#000000" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
        <!--end::Svg Icon-->
        ',
        "name" => "Đánh giá năng lực",
        "role" => $ROLE_HAS_ADMINS,
        "subs-menu" => [
            [
                "name" => "Bài đánh giá",
                "param" => '?type=' . $TYPE_CAPACITY,
                "link" => "admin.contest.list",
                "role" => $ROLE_HAS_ADMINS
            ],
            [
                "name" => "Bộ câu hỏi ",
                "param" => '',
                "link" => "admin.question.index",
                "role" => $ROLE_HAS_ADMINS
            ],
        ]
    ], // Test nang luc
//    [
//        "icon" => '
//         <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Tools/Pantone.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                <polygon points="0 0 24 0 24 24 0 24"/>
//                <path d="M22,15 L22,19 C22,20.1045695 21.1045695,21 20,21 L8,21 C5.790861,21 4,19.209139 4,17 C4,14.790861 5.790861,13 8,13 L20,13 C21.1045695,13 22,13.8954305 22,15 Z M7,19 C8.1045695,19 9,18.1045695 9,17 C9,15.8954305 8.1045695,15 7,15 C5.8954305,15 5,15.8954305 5,17 C5,18.1045695 5.8954305,19 7,19 Z" fill="#000000" opacity="0.3"/>
//                <path d="M15.5421357,5.69999981 L18.3705628,8.52842693 C19.1516114,9.30947552 19.1516114,10.5758055 18.3705628,11.3568541 L9.88528147,19.8421354 C8.3231843,21.4042326 5.79052439,21.4042326 4.22842722,19.8421354 C2.66633005,18.2800383 2.66633005,15.7473784 4.22842722,14.1852812 L12.7137086,5.69999981 C13.4947572,4.91895123 14.7610871,4.91895123 15.5421357,5.69999981 Z M7,19 C8.1045695,19 9,18.1045695 9,17 C9,15.8954305 8.1045695,15 7,15 C5.8954305,15 5,15.8954305 5,17 C5,18.1045695 5.8954305,19 7,19 Z" fill="#000000" opacity="0.3"/>
//                <path d="M5,3 L9,3 C10.1045695,3 11,3.8954305 11,5 L11,17 C11,19.209139 9.209139,21 7,21 C4.790861,21 3,19.209139 3,17 L3,5 C3,3.8954305 3.8954305,3 5,3 Z M7,19 C8.1045695,19 9,18.1045695 9,17 C9,15.8954305 8.1045695,15 7,15 C5.8954305,15 5,15.8954305 5,17 C5,18.1045695 5.8954305,19 7,19 Z" fill="#000000"/>
//            </g>
//        </svg><!--end::Svg Icon--></span>
//        ',
//        "name" => "Thử thách mã ",
//        "role" => $ROLE_HAS_ADMINS,
//        "subs-menu" => [
//            // [
//            //     "name" => "Bộ ngôn ngữ ",
//            //     "param" => '?type=' . $TYPE_CAPACITY,
//            //     "link" => "admin.dev.show",
//            //     "role" => $ROLE_HAS_ADMINS
//            // ],
//            [
//                "name" => "Bộ thử thách ",
//                "param" => '',
//                "link" => "admin.code.manager.list",
//                "role" => $ROLE_HAS_ADMINS
//            ],
//        ]
//    ], // Test nang luc
    [
        "icon" => '
            <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Settings-2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
                </g>
            </svg>
             <!--end::Svg Icon--></span>
        ',
        "name" => "Cấu hình",
        "role" => $ROLE_HAS_ADMINS,
        "subs-menu" => [
//            [
//                "name" => "Chuyên ngành",
//                "role" => $ROLE_HAS_ADMINS,
//                "param" => '',
//                "link" => "admin.major.list",
//            ],
//            [
//                "name" => "Kỹ năng",
//                "role" => $ROLE_HAS_ADMINS,
//                "param" => '',
//                "link" => "admin.skill.index",
//            ],
//            [
//                "name" => "Hình ảnh (slider)",
//                "param" => '',
//                "link" => "admin.sliders.list",
//                "role" => $ROLE_HAS_ADMINS,
//            ],
//            [
//                "name" => "Từ khóa tìm kiếm",
//                "param" => '',
//                "link" => "admin.keyword.list",
//                "role" => $ROLE_HAS_ADMINS,
//            ],
            [
                "name" => "Tài khoản",
                "role" => $ROLE_HAS_ADMINS,
                "param" => '',
                "link" => "admin.acount.list",
            ],
//            [
//                "name" => "Quản lý công việc ",
//                "role" => $ROLE_HAS_ADMINS,
//                "param" => '',
//                "link" => "admin.job",
//            ],
        ]
    ], // Cau hinh
];
