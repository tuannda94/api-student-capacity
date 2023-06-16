<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Quản lí Môn học
Breadcrumbs::for('ManagementStudent', function (BreadcrumbTrail $trail) {
    $trail->push('Quản Lí Môn Học', route('admin.subject.list'));
});
// Quản lí Môn học > Quản lí đề thi
Breadcrumbs::for('Management.exam', function (BreadcrumbTrail $trail,$id,$name) {
    $trail->parent('ManagementStudent');
    $trail->push('Quản lí đề thi ' .$name, route('admin.exam.index',$id));
});

// Quản lí Môn học > Quản Lí bộ câu hỏi
Breadcrumbs::for('ManagementQuestion', function (BreadcrumbTrail $trail) {
    $trail->parent('ManagementStudent');
    $trail->push('Quản Lí bộ câu hỏi', route('admin.question.index'));
});

// Học Kỳ
Breadcrumbs::for('Semeter', function (BreadcrumbTrail $trail) {
    $trail->push('Học kỳ', route('admin.semeter.index'));
});

// Học Kỳ > Quản lí môn học
Breadcrumbs::for('Management.subject', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('Semeter');
    $trail->push('Quản lí môn học' , route('admin.semeter.subject.index',$id));
});

// Học Kỳ > Quản lí ca thi
Breadcrumbs::for('Management.poetry', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('Semeter');
    $trail->push('Quản lí ca thi' , route('admin.poetry.index',$id));
});

// Học Kỳ > Quản lí ca thi > Danh sách ca thi
//Breadcrumbs::for('Management.manage', function (BreadcrumbTrail $trail,$id) {
//    $trail->parent('Management.poetry');
//    $trail->push('Danh sách ca thi' , route('admin.poetry.manage.index',$id));
//});


//Breadcrumbs::for(
//    'Management.manage',
//    fn (BreadcrumbTrail $trail, $id) => $trail
//        ->parent('Management.poetry')
//        ->push('Danh sách ca thi', route('post', $id))
//);



