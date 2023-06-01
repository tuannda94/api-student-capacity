<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\MStudentManager\PoetryStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class studentPoetryController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(
        private PoetryStudent $PoetryStudent
    )
    {
    }

    public function index($id){
        if (!($liststudent = $this->PoetryStudent->GetStudents($id))) return abort(404);
        return view('pages.poetry.students.index',[
            'student' => $liststudent,
            'id' => $id
        ]);
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
            $data[] = $this->PoetryStudent->findUser($value);
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
                'updated_at' => now()
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
