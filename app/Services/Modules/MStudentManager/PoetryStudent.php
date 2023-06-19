<?php

namespace App\Services\Modules\MStudentManager;
use App\Models\studentPoetry;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\modelroles;
use Illuminate\Support\Facades\Validator;

class PoetryStudent implements MPoetryStudentsInterface
{

    public function __construct(
        private studentPoetry $model
    )
    {
    }

        public function GetStudents($id_poetry)
        {
            try {
                $data = $this->model::where('id_poetry',$id_poetry)->paginate(10);
                foreach ($data as $item) {
                    $Checktopic  = $item->playtopic->where('id_poetry',$id_poetry)->first();
                    if ($Checktopic) {
                        $resultCap = $Checktopic->resultCapacity->where('exam_id',$Checktopic->id_exam)->first();
                        $user = $Checktopic->userStudent;
                        if($resultCap == null){
                            $item->scores = 'Chưa làm';
                        }else{
                            $item->scores =  $resultCap->scores;
                        }
                        $item->nameStudent = $user->name;
                        $item->emailStudent = $user->email;
                        $item->mssv = $user->mssv;
                    }
                }
                return $data;

            }catch (\Exception $e){
                return false;
            }
        }
        public function GetStudentsResponse($id_poetry)
        {
            try {
                $data = $this->model::where('id_poetry',$id_poetry)->get();
                $excelData = [];
                foreach ($data as $key => $item) {
                    $Checktopic  = $item->playtopic->where('id_poetry',$id_poetry)->first();
                    if ($Checktopic) {
                        $resultCap = $Checktopic->resultCapacity->where('exam_id',$Checktopic->id_exam)->first();
                        if(empty($resultCap)){
                            continue;
                        }
                        $user = $Checktopic->userStudent;
                        $excelData[] = [
                            $key+1,
                            $user->name,
                            $user->email
                            ,$user->mssv,
                            $resultCap->scores,'Ca thi' . $id_poetry
                        ];
                    }
                }
                return $excelData;


            }catch (\Exception $e){
                return false;
            }
        }

        public function Store()
        {
            try {
                return $this->model::all();
            }catch (\Exception $e){
                return false;
            }
        }

        public function findUser($email,$poetryStd){
            try {
                $users = User::where('email', $email)->first();
                $role = modelroles::where('model_id',$users->id)->first();
                if($role->role_id != 3){
                    return 'Người dùng '.$email.' Không phải Sinh viên không thể thêm vào lớp';
                }
                $checkStudent = $this->model::where('id_student',$users->id)->where('id_poetry',$poetryStd)->get();
                if(count($checkStudent) >= 1 ){
                    return 'Người dùng đã tồn tại';
                }
                return $users;
            }catch (\Exception $e){
                return 'Không tồn tại học sinh có email là ' .$email ;
            }
        }

        public function Item($id){
            try {
                return $this->model::find($id);
            }catch (\exception $e){
                return $e;
            }
        }

}
