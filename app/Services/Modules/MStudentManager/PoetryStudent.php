<?php

namespace App\Services\Modules\MStudentManager;

use App\Models\poetry;
use App\Models\studentPoetry;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\modelroles;
use Illuminate\Support\Facades\Validator;

class PoetryStudent implements MPoetryStudentsInterface
{
    private $table;

    public function __construct(
        private studentPoetry $model
    )
    {
        $this->table = $this->model->getTable();
    }

    public function GetStudents($id_poetry)
    {
        try {
            $user = (new User())->getTable();
            $poetry = (new poetry())->getTable();
//            dd((new User())->getTable());
            $data = $this->model::query()
                ->select(
                    [
                        "{$this->table}.id",
                        "{$this->table}.id_student",
                        "playtopic.exam_name",
                        "{$this->table}.status",
                        "playtopic.has_received_exam",
                        "playtopic.exam_time",
                        "{$user}.name as nameStudent",
                        "{$user}.email as emailStudent",
                        "{$user}.mssv",
                        "{$poetry}.id_subject",
                        'result_capacity.scores'
                    ]
                )
                ->leftJoin($user, "{$user}.id", '=', "{$this->table}.id_student")
                ->leftJoin($poetry, "{$poetry}.id", '=', "{$this->table}.id_poetry")
                ->leftJoin('playtopic', "playtopic.student_poetry_id", '=', "{$this->table}.id")
                ->leftJoin('result_capacity', "result_capacity.playtopic_id", '=', "playtopic.id")
                ->where("{$this->table}.id_poetry", $id_poetry)
                ->orderBy("{$this->table}.id")
                ->paginate(10);
//                $namePoetry = $this->model::with('poetry')
//                    ->whereHas('poetry', function ($query) use ($id_poetry) {
//                        $query->where('id', $id_poetry);
//                    })
//                    ->first();
//            foreach ($data as $item) {
//                $user = $item->userStudent;
//                $poetry = $item->poetry;
//
//                if ($user) {
//                    $item->nameStudent = $user->name;
//                    $item->emailStudent = $user->email;
//                    $item->mssv = $user->mssv;
//                    // Sử dụng $name và $email theo nhu cầu của bạn
//                }
//                if ($poetry) {
//                    $item->id_subject = $poetry->id_subject;
//                }
//            }
            return [$data, $data->first()->id_subject,];

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


        } catch (\Exception $e) {
            return false;
        }
    }

    public function getModel()
    {
        return $this->model;

    }

    public function Store()
    {
        try {
            return $this->model::all();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function findUser($email, $poetryStd)
    {
        try {
            $users = User::where('email', $email)->first();
            $role = modelroles::where('model_id', $users->id)->first();
            if ($role->role_id != 3) {
                return 'Người dùng ' . $email . ' Không phải Sinh viên không thể thêm vào lớp';
            }
            $checkStudent = $this->model::where('id_student', $users->id)->where('id_poetry', $poetryStd)->get();
            if (count($checkStudent) >= 1) {
                return 'Người dùng đã tồn tại';
            }
            return $users;
        } catch (\Exception $e) {
            return 'Không tồn tại học sinh có email là ' . $email;
        }
    }

    public function Item($id)
    {
        try {
            return $this->model::find($id);
        } catch (\exception $e) {
            return $e;
        }
    }

}
