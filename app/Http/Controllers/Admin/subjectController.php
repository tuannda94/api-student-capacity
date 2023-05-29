<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Modules\MContestUser\MContestUserInterface;
use App\Services\Modules\MSubjects\Subject;
use App\Services\Modules\MMajor\MMajorInterface;
use App\Services\Modules\MSkill\MSkillInterface;
use App\Services\Modules\MTeam\MTeamInterface;
use App\Services\Traits\TResponse;
use App\Services\Traits\TStatus;
use App\Services\Traits\TTeamContest;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class subjectController extends Controller
{
    use TUploadImage, TResponse, TTeamContest, TStatus;
    public function __construct(
        private MContestInterface     $contest,
        private MMajorInterface       $majorRepo,
        private Subject  $subject,

        // private Major $major,
        private MTeamInterface        $teamRepo,
        // private Team $team,
        private DB                    $db,
        private Storage               $storage,
        private MSkillInterface       $skill,
        private MContestUserInterface $contestUser,
    )
    {
    }

    public function edit($id){
        try{
            $subject = $this->subject->getItemSubject($id);
            return response()->json([
                'message' => "Thành công",
                'data' => $subject,
            ],200);
        }catch (\Throwable $th){
            return response( ['message' => "Thêm thất bại"],404);
        }
    }
    public function create(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'namebasis' => 'required|min:3|unique:subject,name',
                'status' => 'required'
            ],
            [
                'namebasis.unique' => 'Trường dữ liệu đã tồn tại',
                'namebasis.required' => 'Không để trống tên Môn !',
                'namebasis.min' => 'Tối thiếu 3 ký tự',
                'status.required' => 'Vui lòng chọn trạng thái'
            ]
        );

        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['namebasis', 'status'];
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
            'name' => $request->namebasis,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('subject')->insert($data);
        $id = DB::getPdo()->lastInsertId();
        $data = $request->all();
        return response( ['message' => "Thêm thành công",'data' =>$data],200);
    }
    public function update(Request $request,$id){
        $validator =  Validator::make(
            $request->all(),
            [
                'namebasis' => 'required|min:3',
                'status' => 'required'
            ],
            [
                'namebasis.required' => 'Không để trống tên cơ sở !',
                'namebasis.min' => 'Tối thiếu 3 ký tự',
                'status.required' => 'Không để trống mã cơ sở'
            ]
        );
        if($validator->fails() == 1){
            $errors = $validator->errors();
            $fields = ['namebasis', 'status'];
            foreach ($fields as $field) {
                $fieldErrors = $errors->get($field);

                if ($fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        return response($error,404);
                    }
                }
            }

        }
        $campus = $this->subject->getItemSubject($id);
        if (!$campus) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $campus->name = $request->namebasis;
        $campus->status = $request->status;
        $campus->created_at = $request->start_time;
        $campus->updated_at = $request->end_time;

        $campus->save();
        $data = $request->all();
        $data['id'] = $id;
        return response( ['message' => "Cập nhật thành công",'data' =>$data],200);
    }
    public function index(){
        $this->checkTypeContest();
        if (!($data = $this->subject->ListSubject())) return abort(404);

        return view('pages.subjects.index', [
            'subjects' => $data
        ]);
    }

    public function now_status(Request $request,$id){
        $campus = $this->subject->getItemSubject($id);
        if (!$campus) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        $campus->status = $request->status;
        $campus->save();
        $data = $request->all();
        $data['id'] = $id;
        return response( ['message' => "Cập nhật trạng thái thành công",'data' =>$data],200);
    }

    public function delete($id){
        try {
            $this->subject->getItemSubject($id)->delete();
            return response( ['message' => "Xóa Thành công"],200);
        } catch (\Throwable $th) {
            return response( ['message' => "Xóa Thất bại"],404);
        }
    }

    private function checkTypeContest()
    {
        if (request('type') != config('util.TYPE_CONTEST') && request('type') != config('util.TYPE_TEST')) abort(404);
    }
}
