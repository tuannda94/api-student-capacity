<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\MStudentManager\PoetryStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class studentPoetryController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(
        private PoetryStudent $PoetryStudent
    )
    {
    }

    public function index($id,$id_poetry,$idBlock){
        if (!($liststudent = $this->PoetryStudent->GetStudents($id))) return abort(404);
        return view('pages.poetry.students.index',[
            'student' => $liststudent,
            'id' => $id,
            'id_poetry' => $id_poetry,
            'idBlock' => $idBlock
        ]);
    }

    public function listUser($id){
        if (!($liststudent = $this->PoetryStudent->GetStudents($id))) return abort(404);
//        dd($liststudent);
        return view('pages.Students.accountStudent.listpoetry',[
            'student' => $liststudent,
            'id' => $id
        ]);
    }

    public function UserExportpoint($id){
        $liststudent = $this->PoetryStudent->GetStudentsResponse($id);
        $spreadsheet = new Spreadsheet();

        // Thực hiện xử lý dữ liệu
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'STT');
        $sheet->setCellValue('B1', 'Tên sinh viên');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Mã sinh viên');
        $sheet->setCellValue('E1', 'Điểm');
        $sheet->setCellValue('F1', 'Ca Thi');

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $row = 2;
        $column = 1;
        foreach ($liststudent as $recordata) {
            foreach ($recordata as  $value) {
                $sheet->setCellValueByColumnAndRow($column, $row, $value);
                $sheet->getStyleByColumnAndRow($column, $row)->applyFromArray($borderStyle);
                $column++;
            }
            $row++;
            $column = 1;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);

// Định dạng căn giữa và màu nền cho hàng tiêu đề
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

        $writer = new Xlsx($spreadsheet);
        $outputFileName = 'diem_thi_sinh_vien_ca_thi_'.$id.'.xlsx';
        $writer->save($outputFileName);
        return response()->download($outputFileName)->deleteFileAfterSend(true,$outputFileName);
    }

    public function create(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'emailStudent' => 'required',
                'status' => 'required'
            ],
            [
                'emailStudent.required' => 'Không để trống email!',
                'status.required' => 'Vui lòng chọn trạng thái!'
            ]
        );

        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['emailStudent','status'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error,404);
                    }
                }
            }

        }
        $data = null;
        foreach ($request->emailStudent as $value){
            $data[] = $this->PoetryStudent->findUser($value,$request->id_poetry);
        }
        $errors = 0;
        $data = array_filter($data, function ($item) use (&$errors) {
            if(!is_object($item)){
                $errors++;
            }
            return is_object($item);
        });


        $success = 0;
        foreach ($data as $object){
            $dataInsert = [
                'id_poetry' => $request->id_poetry,
                'id_student' => $object->id,
                'status' =>  $request->status,
                'created_at' => now(),
                'updated_at' => null
            ];
            DB::table('student_poetry')->insert($dataInsert);
            $success++;
        }
        return response( ['message' => "Thành công " . $success .'<br> Thất bại ' . $errors .'<br>Vui lòng chờ 5s để làm mới dữ liệu','data' => $data],200);
    }

    public function now_status(Request $request,$id){
        $studentPoetry = $this->PoetryStudent->Item($id);
        if (!$studentPoetry) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $studentPoetry->status = $request->status;
        $studentPoetry->updated_at = now();
        $studentPoetry->save();
        $data = $request->all();
        $data['id'] = $id;
        return response( ['message' => "Cập nhật trạng thái thành công",'data' =>$data],200);
    }

    public function delete($id){
        try {
            $this->PoetryStudent->Item($id)->delete();
            return response( ['message' => "Xóa Thành công"],200);
        } catch (\Throwable $th) {
            return response( ['message' => 'Xóa thất bại'],404);
        }
    }
}
