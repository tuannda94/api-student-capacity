<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Modules\MStudentManager\PoetryStudent;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\playtopics\playtopic;
use App\Services\Modules\MCampus\Campus;
use App\Services\Modules\MExam\Exam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class playtopicController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(
        private playtopic $playtopicModel,
        private Campus $Campus,
        private Exam $exam,
        private PoetryStudent $PoetryStudent
    )
    {
    }

    public function index($id,$id_subject){
        $playtopic = $this->playtopicModel->getList($id);
        $total = $playtopic[0]->total;
        $campusList = $this->Campus->getList()->get();
        return view('pages.poetry.playtopic.index',['playtopics' => $playtopic,'campusList' => $campusList,'id_subject' => $id_subject,'id_poetry' => $id,'total'=>$total]);
    }

    public function listExam($idCampus,$idSubject){
        $data = $this->exam->getListExam($idCampus,$idSubject);

        return response()->json(['data' => $data],200);

    }

    public function AddTopic(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'campuses_id' => 'required',
                'id_subject' => 'required',
                'exam_id' => 'required'
            ],
            [
                'campuses_id.required' => 'Vui lòng chọn cơ sở!',
                'exam_id.required' => 'Vui lòng chọn đề!',
                'id_subject.required' => 'Không có data môn học'
            ]
        );

        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['campuses_id','id_subject','exam_id'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error,404);
                    }
                }
            }

        }

        if (!($liststudent = $this->PoetryStudent->GetStudents($request->id_poetry))) return abort(404);

        if(count($liststudent) ==0){
            return response('Không có học sinh trong ca thi này',404);
        }

        foreach ($liststudent as $object){
            $dataInsert = [
                'id_user' => $object->id,
                'id_exam' => $request->exam_id,
                'id_poetry' =>  $request->id_poetry,
                'id_campus' =>  $request->campuses_id,
                'id_subject' =>  $request->id_subject,
                'total' =>  1,
                'created_at' => now(),
                'updated_at' => null
            ];
            DB::table('playtopic')->insert($dataInsert);
        }
        return response( ['message' => "Thành công ".'<br>Vui lòng chờ 5s để làm mới dữ liệu'],200);
    }

    public function AddTopicReload(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'campuses_id' => 'required',
                'id_subject' => 'required',
                'exam_id' => 'required'
            ],
            [
                'campuses_id.required' => 'Vui lòng chọn cơ sở!',
                'exam_id.required' => 'Vui lòng chọn đề!',
                'id_subject.required' => 'Không có data môn học'
            ]
        );

        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['campuses_id','id_subject','exam_id'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error,404);
                    }
                }
            }

        }

        if (!($liststudent = $this->PoetryStudent->GetStudents($request->id_poetry))) return abort(404);

        if(count($liststudent) ==0){
            return response('Không có học sinh trong ca thi này',404);
        }
        $playtopic = $this->playtopicModel->getList($request->id_poetry);
        foreach ($playtopic as $value){
            $value->delete();
        }
        foreach ($liststudent as $object){
            $dataInsert = [
                'id_user' => $object->id,
                'id_exam' => $request->exam_id,
                'id_poetry' =>  $request->id_poetry,
                'id_campus' =>  $request->campuses_id,
                'id_subject' =>  $request->id_subject,
                'total' =>  1,
                'created_at' => now(),
                'updated_at' => null
            ];
            DB::table('playtopic')->insert($dataInsert);
        }
        return response( ['message' => "Thành công ".'<br>Vui lòng chờ 5s để làm mới dữ liệu'],200);
    }
}
