<?php

use App\Models\User;
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
// Học Kỳ > Blocks
Breadcrumbs::for('Management.block', function (BreadcrumbTrail $trail,$id_semeter) {
    $trail->parent('Semeter');
    $trail->push('Blocks' , route('admin.semeter.block',$id_semeter));
});
// Học Kỳ > Blocks > Quản lí ca thi
Breadcrumbs::for('Management.poetry', function (BreadcrumbTrail $trail,$id,$idblock) {
    $trail->parent('Management.block',$id);
    $trail->push('Quản lí ca thi' , route('admin.poetry.index',['id' => $id,'id_block' => $idblock]));
});

// Học Kỳ > Quản lí ca thi > Danh sách ca thi
Breadcrumbs::for('manageSemeter', function (BreadcrumbTrail $trail,$args) {
    $trail->parent('Management.poetry',$args['id_poetry'],$args['id_block']);
    $trail->push('Danh sách ca thi' , route('admin.poetry.manage.index',$args));
});



//Breadcrumbs::for(
//    'Management.manage',
//    fn (BreadcrumbTrail $trail, $id) => $trail
//        ->parent('Management.poetry')
//        ->push('Danh sách ca thi', route('post', $id))
//);

// Quản lí sinh viên
Breadcrumbs::for('Students', function (BreadcrumbTrail $trail) {
    $trail->push('Quản Lí sinh viên', route('manage.student.list'));
});

// Quản lí sinh viên > Quản lí điểm ca thi
Breadcrumbs::for('StudentsPoint', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('Students');
    $trail->push('Quản Lí sinh viên', route('admin.manage.semeter.index',$id));
});

Breadcrumbs::for('StudentsPointDetail', function (BreadcrumbTrail $trail, $id,$id_poetry) {
    $trail->parent('StudentsPoint',$id_poetry);
    $trail->push('Quản Lí điểm sinh viên', route('manage.student.view',['id_user' => $id,'id_poetry' => $id_poetry]));
});





