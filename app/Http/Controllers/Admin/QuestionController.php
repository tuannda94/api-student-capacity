<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuestionsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\ImportQuestion;
use App\Imports\QuestionsImport;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Skill;
use App\Models\subject;
use App\Models\ClassModel;
use App\Models\poetry;
use App\Models\semeter_subject;
use App\Services\Modules\MAnswer\MAnswerInterface;
use App\Services\Modules\MExam\MExamInterface;
use App\Services\Modules\MQuestion\MQuestionInterface;
use App\Services\Modules\MSkill\MSkillInterface;
use App\Services\Traits\TStatus;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class QuestionController extends Controller
{
    use TStatus;
    use TUploadImage;

    protected $skillModel;
    protected $questionModel;
    protected $answerModel;
    protected $examModel;
    protected $subjectModel;
    protected $classModel;
    protected $poetry;
    protected $semeter_subject;

    public function __construct(
        Skill                      $skill,
        Question                   $question,
        Answer                     $answer,
        Exam                       $exam,
        private MSkillInterface    $skillRepo,
        private MQuestionInterface $questionRepo,
        subject                     $subject,
        ClassModel $class,
        poetry $poetry,
        semeter_subject $semeter_subject
    )
    {
        $this->skillModel = $skill;
        $this->questionModel = $question;
        $this->answerModel = $answer;
        $this->examModel = $exam;
        $this->subjectModel = $subject;
        $this->classModel = $class;
        $this->poetry = $poetry;
        $this->semeter_subject = $semeter_subject;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $data = $this->questionModel::when(request()->has('question_soft_delete'), function ($q) {
            return $q->onlyTrashed();
        })
            ->status(request('status'))
            ->search(request('q') ?? null, ['content'])
            ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'questions')
            ->whenWhereHasRelationship(request('skill') ?? null, 'skills', 'skills.id', (request()->has('skill') && request('skill') == 0) ? true : false)
            // ->hasRequest(['rank' => request('level') ?? null, 'type' => request('type') ?? null]);
            ->when(request()->has('level'), function ($q) {
                $q->where('rank', request('level'));
            })
            ->when(request()->has('type'), function ($q) {
                $q->where('type', request('type'));
            });
        $data->with(['skills', 'answers']);
        return $data;
    }

    public function getQuestion($id)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');

        $data = $this->questionModel::when(request()->has('question_soft_delete'), function ($q) {
            return $q->onlyTrashed();
        })
            ->status(request('status'))
            ->search(request('q') ?? null, ['content'])
            ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'questions')
            ->whenWhereHasRelationship(request('skill') ?? null, 'skills', 'skills.id', (request()->has('skill') && request('skill') == 0) ? true : false)
            // ->hasRequest(['rank' => request('level') ?? null, 'type' => request('type') ?? null]);
            ->when(request()->has('level'), function ($q) {
                $q->where('rank', request('level'));
            })
            ->when(request()->has('type'), function ($q) {
                $q->where('type', request('type'));
            })->whereHas('questions', function ($q) use ($id) {
                $q->where('exam_id', $id);
            });
        $data->with(['skills', 'answers']);
        return $data;
    }

    public function indexSubject($id,$id_subject,$name)
    {
        $skills = $this->skillModel::all();
        if (!($questions = $this->getQuestion($id)->paginate(request('limit') ?? 10))) return abort(404);
        return view('pages.subjects.question.list', [
            'questions' => $questions,
            'skills' => $skills,
            'id' => $id,
            'id_subject' => $id_subject,
            'name' => $name
        ]);
    }

    public function index()
    {
        $skills = $this->skillModel::all();
        if (!($questions = $this->getList()->paginate(request('limit') ?? 10))) return abort(404);

        // dd($questions);
        return view('pages.question.list', [
            'questions' => $questions,
            'skills' => $skills,
        ]);
    }

    public function indexApi()
    {
        try {
            if (!($questions = $this->getList()->take(request('take') ?? 10)->get()))
                throw new \Exception("Question not found");
            return response()->json([
                'status' => true,
                'payload' => $questions,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Hệ thống đã xảy ra lỗi ! ' . $th->getMessage(),
            ], 404);
        }
    }

    public function create()
    {

        $skills = $this->skillModel::select('name', 'id')->get();
        return view(
            'pages.question.add',
            [
                'skills' => $skills
            ]
        );
    }

    public function store(Request $request)
    {
        // dump(count($request->answers));
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'content' => 'required',
                'type' => 'required|numeric',
                'status' => 'required|numeric',
                'rank' => 'required|numeric',
                'skill' => 'required',
                'skill.*' => 'required',
                'answers.*.content' => 'required',
                // 'answers.*.is_correct' => 'required'
            ],
            [
                'answers.*.content.required' => 'Chưa nhập trường này !',
                // 'answers.*.is_correct.required' => 'Chưa nhập trường này !',
                'content.required' => 'Chưa nhập trường này !',
                'type.required' => 'Chưa nhập trường này !',
                'type.numeric' => 'Sai định dạng !',
                'status.required' => 'Chưa nhập trường này !',
                'status.numeric' => 'Sai định dạng !',
                'rank.required' => 'Chưa nhập trường này !',
                'rank.numeric' => 'Sai định dạng !',
                'skill.required' => 'Chưa nhập trường này !',
                'skill.*.required' => 'Chưa nhập trường này !',
            ]
        );
        if ($validator->fails() || !isset($request->answers)) {
            if (!isset($request->answers)) {
                return redirect()->back()->withErrors($validator)->with('errorAnswerConten', 'Phải ít nhất 3 đáp án !!')->withInput($request->input());
            } else {
                if (count($request->answers) <= 2) return redirect()->back()->withErrors($validator)->with('errorAnswerConten', 'Phải ít nhất 3 đáp án !!')->withInput($request->input());
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $question = $this->questionModel::create([
                'content' => $request->content,
                'type' => $request->type,
                'status' => $request->status,
                'rank' => $request->rank,
            ]);
            $question->skills()->syncWithoutDetaching($request->skill);
            foreach ($request->answers as $value) {
                if ($value['content'] != null) {
                    $this->answerModel::create([
                        'content' => $value['content'],
                        'question_id' => $question->id,
                        'is_correct' => $value['is_correct'][0] ?? 0
                    ]);
                }
            }
            DB::commit();
            return Redirect::route('admin.question.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function show(Question $questions)
    {
        //
    }

    public function edit(Question $questions, $id)
    {
        $skills = $this->skillModel::select('name', 'id')->get();
        $question = $this->questionModel::find($id)->load(['answers', 'skills']);
        // dd($question);
        return view('pages.question.edit', [
            'skills' => $skills,
            'question' => $question,
        ]);
    }

    public function editSubject(Question $questions, $id)
    {
        $skills = $this->skillModel::select('name', 'id')->get();
        $question = $this->questionModel::find($id)->load(['answers', 'skills']);
        // dd($question);
        return view('pages.subjects.question.edit', [
            'skills' => $skills,
            'question' => $question,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                // 'content' => 'required|unique:questions,content,' . $id . '',
                'content' => 'required',
                'type' => 'required|numeric',
                'status' => 'required|numeric',
                'rank' => 'required|numeric',
                'skill' => 'required',
                'skill.*' => 'required',
                'answers.*.content' => 'required',
            ],
            [
                'answers.*.content.required' => 'Chưa nhập trường này !',
                'content.required' => 'Chưa nhập trường này !',
                // 'content.unique' => 'Nội dung đã tồn tại !',
                'type.required' => 'Chưa nhập trường này !',
                'type.numeric' => 'Sai định dạng !',
                'status.required' => 'Chưa nhập trường này !',
                'status.numeric' => 'Sai định dạng !',
                'rank.required' => 'Chưa nhập trường này !',
                'rank.numeric' => 'Sai định dạng !',
                'skill.required' => 'Chưa nhập trường này !',
                'skill.*.required' => 'Chưa nhập trường này !',
            ]
        );

        if ($validator->fails() || count($request->answers) <= 2) {
            if (count($request->answers) <= 2) {
                return redirect()->back()->withErrors($validator)->with('errorAnswerConten', 'Phải ít nhất 3 đáp án !!')->withInput($request->input());
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        // dd($request->all());
        try {
            $question = $this->questionModel::find($id);
            $question->update([
                'content' => $request->content,
                'type' => $request->type,
                'status' => $request->status,
                'rank' => $request->rank,
            ]);
            $question->skills()->sync($request->skill);
            foreach ($request->answers as $value) {
                if (isset($value['answer_id'])) {
                    $this->answerModel::find($value['answer_id'])->forceDelete();
                }
            }
            foreach ($request->answers as $value) {
                if ($value['content'] != null) {
                    $this->answerModel::create([
                        'content' => $value['content'],
                        'question_id' => $question->id,
                        'is_correct' => $value['is_correct'][0] ?? 0
                    ]);
                }
            }
            DB::commit();
            return Redirect::route('admin.question.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function destroy(Question $questions, $id)
    {
        $this->questionModel::find($id)->delete();
        return Redirect::route('admin.question.index');
    }

    public function destroysubject($id, $id_exam)
    {
        $this->questionModel::find($id)->delete();
        $exams = $this->examModel->find($id_exam);
        $exams->total_questions = $exams->total_questions - 1;
        $exams->save();
        return redirect()->route('admin.subject.question.index', $id_exam);
    }

    public function getModelDataStatus($id)
    {
        return $this->questionModel::find($id);
    }

    public function softDeleteList()
    {
        $skills = $this->skillModel::all();
        if (!($questions = $this->getList()->paginate(request('limit') ?? 5))) return abort(404);
        // dd($questions);
        return view('pages.question.list-soft-delete', [
            'questions' => $questions,
            'skills' => $skills,
        ]);
    }

    public function softDeleteListSubject()
    {
        $skills = $this->skillModel::all();
        if (!($questions = $this->getList()->paginate(request('limit') ?? 5))) return abort(404);
        // dd($questions);
        return view('pages.question.list-soft-delete', [
            'questions' => $questions,
            'skills' => $skills,
        ]);
    }

    public function delete($id)
    {
        try {
            $this->questionModel::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function deletesubject($id)
    {
        try {
            $this->questionModel::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function restoreDelete($id)
    {
        try {
            $this->questionModel::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function save_questions(Request $request)
    {
        try {
            $ids = [];
            $exams = $this->examModel::whereId($request->exam_id)->first();
            foreach ($request->question_ids ?? [] as $question_id) {
                array_push($ids, (int)$question_id['id']);
            }
            $exams->questions()->sync($ids);
            return response()->json([
                'status' => true,
                'payload' => 'Cập nhật trạng thái thành công  !',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng câu hỏi  ! ' . $th->getMessage(),
                'data' => $request->all(),
            ]);
        }
    }

    public function remove_question_by_exams(Request $request)
    {
        try {
            $exams = $this->examModel::whereId($request->exam_id)->first();
            $exams->questions()->detach($request->questions_id);
            return response()->json([
                'status' => true,
                'payload' => 'Cập nhật trạng thái thành công  !',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể xóa câu hỏi  !',
            ]);
        }
    }

    public function import(ImportQuestion $request)
    {
        try {
            Excel::import(new QuestionsImport(), $request->ex_file);
            return response()->json([
                "status" => true,
                "payload" => "Thành công "
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "errors" => [
                    "ex_file" => $th->getMessage()
                ]
            ], 400);
        }
    }

    public function importAndRunExam(ImportQuestion $request, $exam_id)
    {
        try {
            $this->readExcel($request->ex_file, $exam_id);
//            $import = new QuestionsImport($exam_id);
//            Excel::import($import, $request->ex_file);
//            dd();
            return response()->json([
                "status" => true,
                "payload" => "Thành công "
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "errors" => [
                    "ex_file" => $th->getMessage()
                ]
            ], 400);
        }
    }
    public function importAndRunSemeter(ImportQuestion $request, $semeter_id,$idBlock)
    {
        try {
            $this->readExClass($request->ex_file, $semeter_id,$idBlock);
//            $import = new QuestionsImport($exam_id);
//            Excel::import($import, $request->ex_file);
//            dd();
//            return response()->json([
//                "status" => true,
//                "payload" => "Thành công "
//            ]);
            return redirect()->route('admin.poetry.index',['id' => $semeter_id,'id_block' => $idBlock]);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "errors" => [
                    "ex_file" => $th->getMessage()
                ]
            ], 400);
        }
    }
    public function readExcel($file, $exam_id)
    {
        $spreadsheet = IOFactory::load($file);
        $sheetCount = $spreadsheet->getSheetCount();

        // Lấy ra sheet chứa câu hỏi
        $questionsSheet = $spreadsheet->getSheet(0);
        $questionsArr = $questionsSheet->toArray();

        // Lấy ra sheet chứa ảnh
        $imagesSheet = null;
        if ($sheetCount > 1) {
            $imagesSheet = $spreadsheet->getSheet(1);
        }

        $data = [];
        $count = 0;
        $imgCodeToQuestionId = [];
        foreach ($questionsArr as $key => $row) {
            if ($key == 0) continue;
            $line = $key + 1;

            if (
                $row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['TYPE']] != null
                || trim($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['TYPE']]) != ""
            ) {

                $count = $count + 1;
                if ($count > 1) {
                    $data[] = $arr;
                }
                $arr = [];
                $arr['imgCode'] = [];
                $arr['questions']['content'] = $this->catchError($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['QUESTION']], "Thiếu câu hỏi dòng $line");
                $arr['imgCode'] = $this->getImgCode($arr['questions']['content'], $arr['imgCode']);
                $arr['questions']['type'] = $row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['TYPE']] == config("util.EXCEL_QESTIONS")["TYPE"] ? 0 : 1;
                $rank = $this->catchError($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['RANK']], "Thiếu mức độ dòng $line");
                $arr['questions']['rank'] = (($rank == config("util.EXCEL_QESTIONS")["RANKS"][0]) ? 0 : (($rank == config("util.EXCEL_QESTIONS")["RANKS"][1]) ? 1 : 2));
                $arr['skill'] = [];
                if (isset($row[config("util.EXCEL_QESTIONS")['KEY_COLUMNS']['SKILL']]))
                    $arr['skill'] = explode(",", $row[config("util.EXCEL_QESTIONS")['KEY_COLUMNS']['SKILL']] ?? "");

                $dataA = [
                    "content" => $this->catchError($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['ANSWER']], "Thiếu câu trả lời dòng $line"),
                    "is_correct" => $row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']["IS_CORRECT"]] == config("util.EXCEL_QESTIONS")["IS_CORRECT"] ? 1 : 0,
                ];
                $arr['imgCode'] = $this->getImgCode($dataA['content'], $arr['imgCode']);
                $arr['answers'] = [];
                array_push($arr['answers'], $dataA);
            } else {
                if (($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['ANSWER']] == null || trim($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['ANSWER']]) == "")) continue;
                $dataA = [
                    "content" => $row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['ANSWER']],
                    "is_correct" => $row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']["IS_CORRECT"]] == config("util.EXCEL_QESTIONS")["IS_CORRECT"] ? 1 : 0,
                ];
                $arr['imgCode'] = $this->getImgCode($dataA['content'], $arr['imgCode']);
                array_push($arr['answers'], $dataA);
            }
        }
        $data[] = $arr;

        // Lấy ra các đối tượng Drawing trong sheet
        if ($imagesSheet) {

            // Chuyển sheet thành một mảng dữ liệu
            $sheetData = $imagesSheet->toArray();

            $imgCodeArr = array_reduce($data, function ($acc, $ques) {
                $acc = array_merge($acc, array_map(function ($imgCode) {
                    return trim($imgCode, '[]');
                }, $ques['imgCode']));
                return $acc;
            }, []);

            $drawings = $imagesSheet->getDrawingCollection();
            $results = [];
            $imgArr = [];
            $imgMemArr = [];

            // Duyệt qua các đối tượng Drawing
            foreach ($drawings as $index => $drawing) {
                // Kiểm tra xem đối tượng Drawing có phải là MemoryDrawing hay không
                $code = $sheetData[$index + 1][0];
                if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing) {
                    // Lấy ảnh từ phương thức getImageResource
                    $image = $drawing->getImageResource();
                    // Xác định định dạng của ảnh dựa vào phương thức getMimeType
                    switch ($drawing->getMimeType()) {
                        case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_PNG:
                            $format = "png";
                            break;
                        case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_GIF:
                            $format = "gif";
                            break;
                        case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_JPEG:
                            $format = "jpg";
                            break;
                    }
                    // Tạo một tên file cho ảnh
                    $filename = "image_question" . md5(time()) . '_' . uniqid() . "." . $format;
//                    $path = "questions/" . $filename;
                    $imgMemArr[$code] = [
                        'path' => $filename,
                        'image' => $image,
                    ];
                } else {
                    // Lấy ảnh từ phương thức getPath
                    $path = $drawing->getPath();
                    // Đọc nội dung của ảnh bằng cách sử dụng fopen và fread
                    $file = fopen($path, "r");
                    $content = "";
                    while (!feof($file)) {
                        $content .= fread($file, 1024);
                    }
                    // Lấy định dạng của ảnh từ phương thức getExtension
                    $format = $drawing->getExtension();
                    // Tạo một tên file cho ảnh
                    $filename = "image_question" . md5(time()) . '_' . uniqid() . "." . $format;
//                    $path = "" . $filename;
                    $imgArr[$code] = [
                        'path' => $filename,
                        'content' => $content
                    ];
                }
                $results[$code] = $path;
            }
        }

        if ($imagesSheet && !empty($results)) {
            // Nếu số ảnh trong file excel < số mã ảnh thì báo lỗi
            $imgCodeDiff = array_diff($imgCodeArr, array_keys($results));
            if ($imgCodeDiff) {
                $this->catchError(null, "Thiếu ảnh ở các mã " . implode(', ', $imgCodeDiff));
            }
        }

        foreach ($data as $arr) {
            $this->storeQuestionAnswer($arr, $exam_id, $imgCodeToQuestionId);
        }

        // Lấy dữ liệu để insert vào bảng question_images
        if (!empty($imgCodeToQuestionId)) {
            $imageQuestionArr = [];
            foreach ($imgCodeToQuestionId as $imgCode => $questionId) {
                $path = $results[$imgCode];
                $imageQuestionArr[$imgCode] = [
                    'path' => $path,
                    'img_code' => $imgCode,
                    'question_id' => $questionId,
                ];
            }
        }

        if ($imagesSheet && !empty($imageQuestionArr)) {
            // Thêm bản ghi vào bảng

            // Lưu ảnh
            if (!empty($imgArr)) {
                foreach ($imgArr as $imgCode => $item) {
                    if (!empty($imageQuestionArr[$imgCode])) {
                        $imageQuestionArr[$imgCode]['path'] = $this->uploadFile(file: 'abc', fileName: $item['path'], content: $item['content']);
                    }
                }
            }

            // Lưu ảnh
            if (!empty($imgMemArr)) {
                foreach ($imgMemArr as $item) {
                    if (!empty($imageQuestionArr[$imgCode])) {
                        $tempPath = sys_get_temp_dir() . $item['path'];
                        imagepng($item['image'], $tempPath);
                        $content = file_get_contents($tempPath);
                        $imageQuestionArr[$imgCode]['path'] = $this->uploadFile(file: 'abc', fileName: $item['path'], content: $content);
                        unlink($tempPath);
                    }
                }
            }
            DB::table('question_images')->insert($imageQuestionArr);
        }

        // Cập nhật số câu hỏi cho đề thi
        $exams = Exam::query()->find($exam_id);
        $exams->total_questions += $count;
        $exams->save();
    }

    public function readExClass($file, $id_semeter,$idBlock)
    {
        $spreadsheet = IOFactory::load($file);
        $sheetCount = $spreadsheet->getSheetCount();
        // Lấy ra sheet chứa câu hỏi
        $questionsSheet = $spreadsheet->getSheet(0);
        $infoSubject= $questionsSheet->toArray();
        unset($infoSubject[0]);
        $infoSubject = array_values($infoSubject);
        $arrItem = [];
        foreach ($infoSubject as $value){
            $subjectFind = $this->subjectModel->where('code_subject',$value[4])->first();
            $id_subject = $subjectFind != null ? $subjectFind->id : null;
            if($subjectFind == null){
                $id_subject = DB::table('subject')->insertGetId(
                    [
                        'name' => $value[3],
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => NULL,
                        'code_subject' =>  $value[4]
                    ]
                );



            }
            DB::table('block_subject')->insertGetId(
                [
                    'id_subject' => $id_subject,
                    'id_block' => $idBlock
                ]
            );

            $Classfind = $this->classModel->where('name',$value[5])->first();
            $idClass = $Classfind != null ? $Classfind->id : null;
            if($Classfind == null){
                $idClass = DB::table('class')->insertGetId(
                    [
                        'name' => $value[5],
                        'code_class' => NULL,
                        'created_at' => now(),
                        'updated_at' => NULL
                    ]
                );
            }
            $semeterSubjectFind =    $this->semeter_subject->where('id_semeter',$id_semeter)->where('id_subject',$id_subject)->first();
            if($semeterSubjectFind == null){
               DB::table('semester_subject')->insert(
                    [
                        'id_semeter' =>$id_semeter,
                        'id_subject' => $id_subject,
                        'status' => now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => NULL,
                        'deleted_at' => NULL
                    ]
                );
            }
            $time = $this->timeNow($value[1]);
            $arrItem[] = [
                'id_semeter' => $id_semeter,
                'id_subject' => $id_subject,
                'id_class' => $idClass,
                'id_examination' => $value[2],
                'id_campus' => $value[7],
                'status' => 1,
                'start_time' => $time,
                'end_time' => $time,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ];
        }
//        dd($arrItem);
        DB::table('poetry')->insert($arrItem);

    }
    public function catchError($data, $message)
    {
        if (($data == null || trim($data) == "")) {
            throw new \Exception($message);
        }
//        return is_string($data) ? utf8_encode($data) : $data;
        return $data;
    }

    public function storeQuestionAnswer($data, $exam_id, &$imgCodeToQuestionId)
    {
        DB::transaction(function () use ($data, $exam_id, &$imgCodeToQuestionId) {
            $question = app(MQuestionInterface::class)->createQuestionsAndAttchSkill($data['questions'], $data['skill']);
            if (!$question) throw new \Exception("Error create question ");
            if ($exam_id) app(MExamInterface::class)->attachQuestion($exam_id, $question->id);
            app(MAnswerInterface::class)->createAnswerByIdQuestion($data['answers'], $question->id);
            foreach ($data['imgCode'] as $imgCode) {
                $imgCode = trim($imgCode, '[]');
                $imgCodeToQuestionId[$imgCode] = $question->id;
            }
        });
    }

    public function getImgCode($text, $arr = [])
    {
        $regImgCode = '/\[anh\d\]/';
        preg_match_all($regImgCode, $text, $imgCode);
        if (!empty($imgCode[0])) {
            $arr = array_merge($arr, $imgCode[0]);
        }
        return $arr;
    }

    public function exportQe()
    {
        $point = [
            [1, 2, 3],
            [2, 5, 9]
        ];
        $data = (object)array(
            'points' => $point,
        );
        $export = new QuestionsExport([$data]);
        return Excel::download($export, 'abc.xlsx');
        // return Excel::download(new QuestionsExport, 'question.xlsx');
        // return Excel::download(new QuestionsExport, 'invoices.xlsx', true, ['X-Vapor-Base64-Encode' => 'True']);
    }

    public function skillQuestionApi()
    {
        $data = $this->questionRepo->getQuestionSkill();
        return $this->responseApi(true, $data);
    }

    public function timeNow($timeFormat){
        $dateString = $timeFormat;
        $date = Carbon::createFromFormat('d/m/Y', $dateString);
        $formattedDate = $date->format('Y-m-d');
        $currentDateTime = Carbon::now();
        return  $formattedDate . ' ' . $currentDateTime->format('H:i:s');
    }
}
