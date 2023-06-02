<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\Modules\poetry\poetry;
use App\Services\Modules\MSemeter\Semeter;
class PoetryController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(
        private poetry $poetry,
        private Semeter $semeter
    )
    {
    }

    public function index(){

        $data = $this->poetry->ListPoetry();
        $semeter = $this->semeter->ListSemeter();
        return view('pages.poetry.index',['poetry' => $data,'semeter' => $semeter]);
    }

    public function create(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'semeter_id' => 'required',
                'subject_id' => 'required',
                'status' => 'required',
                'start_time_semeter' => 'nullable|date',
                'end_time_semeter' => 'nullable|date|after:start_time_semeter'
            ],
            [
                'semeter_id.required' => 'Vui lòng chọn tên kỳ học !',
                'subject_id.required' => 'Vui lòng chọn môn học !',
                'status.required' => 'Vui lòng chọn trạng thái',
                'start_time_semeter.nullable' => 'Vui lòng chọn thời gian bắt đầu',
                'end_time_semeter.nullable' => 'Vui lòng chọn thời gian kết thúc',
                'end_time_semeter.after' => 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu',
            ]
        );

        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['semeter_id', 'subject_id','status', 'start_time_semeter','end_time_semeter'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error,404);
                    }
                }
            }

        }
        $data = [
            'id_semeter' => $request->semeter_id,
            'id_subject' => $request->subject_id,
            'status' => $request->status,
            'start_time' => $request->start_time_semeter,
            'end_time' => $request->end_time_semeter,
            'created_at' => now(),
            'updated_at' => null
        ];

        DB::table('poetry')->insert($data);
        $id = DB::getPdo()->lastInsertId();
        $data = array_merge($data,$this->poetry->getItem($id)) ;

//        $data = $request->all();
        $data['id'] = $id;
        return response( ['message' => "Thêm thành công",'data' =>$data],200);
    }

    public function now_status(Request $request,$id){
        $poetry = $this->poetry->getItempoetry($id);
        if (!$poetry) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $poetry->status = $request->status;
        $poetry->updated_at = now();
        $poetry->save();
        $data = $request->all();
        $data['id'] = $id;
        return response( ['message' => "Cập nhật trạng thái thành công",'data' =>$data],200);
    }

    public function delete($id){
        try {
            $this->poetry->getItempoetry($id)->delete();
            return response( ['message' => "Xóa Thành công"],200);
        } catch (\Throwable $th) {
            return response( ['message' => 'Xóa thất bại'],404);
        }
    }

    public function edit($id){
        try{
            $poetry = $this->poetry->getItempoetry($id);
            return response()->json([
                'message' => "Thành công",
                'data' => $poetry,
            ],200);
        }catch (\Throwable $th){
            return response( ['message' => "Thêm thất bại"],404);
        }
    }

    public function update(Request $request,$id){
        $validator =  Validator::make(
            $request->all(),
            [
                'semeter_id_update' => 'required',
                'subject_id_update' => 'required',
                'status_update' => 'required',
                'start_time_semeter' => 'nullable|date',
                'end_time_semeter' => 'nullable|date|after:start_time_semeter'
            ],
            [
                'semeter_id_update.required' => 'Vui lòng chọn tên kỳ học !',
                'subject_id_update.required' => 'Vui lòng chọn môn học !',
                'status_update.required' => 'Vui lòng chọn trạng thái',
                'start_time_semeter.nullable' => 'Vui lòng chọn thời gian bắt đầu',
                'end_time_semeter.nullable' => 'Vui lòng chọn thời gian kết thúc',
                'end_time_semeter.after' => 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu',
            ]
        );
        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['semeter_id', 'subject_id','status', 'start_time_semeter','end_time_semeter'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error,404);
                    }
                }
            }

        }
        $poetry = $this->poetry->getItempoetry($id);
        if (!$poetry) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $poetry->id_semeter = $request->semeter_id_update;
        $poetry->id_subject	 =  $request->subject_id_update;
        $poetry->status = $request->status_update;
        $poetry->start_time = $request->start_time_semeter;
        $poetry->end_time = $request->end_time_semeter;
        $poetry->updated_at = now();

        $poetry->save();
        $data = $request->all();
        $data['id'] = $id;
        $data['end_time_semeter'] =  $this->formatdate($data['end_time_semeter']);
        $data['start_time_semeter'] =   $this->formatdate($data['start_time_semeter']);
        $data =array_merge($data,$this->poetry->getItem($id))   ;
        return response( ['message' => "Cập nhật thành công",'data' => $data],200);
    }

    function formatdate($dateformat){
        $date_start = $dateformat;
        $timestamp = strtotime($date_start);
        return date('d-m-Y', $timestamp);

    }

}
