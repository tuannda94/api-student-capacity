<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrequentlyAskedQuestion;
use App\Services\Builder\Builder;
use App\Services\Traits\TResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FrequentlyAskedQuestionController extends Controller
{
    use TResponse;
    private $faq;

    public function __construct(FrequentlyAskedQuestion $faq) {
        $this->faq = $faq;
    }

    private function getList(Request $request) 
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $type = $request->has('type') ? $request->type : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = $this->faq::where('question', 'like', "%$keyword%")
            ->with(['upRatings','downRatings']);
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        if ($type != "") {
            $query->where('type', $type);
        } 
        
        return $query;
    }

    /**ADMIN CRUD */ 
    public function index(Request $request) {
        try {
            $faqs = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            
            return view('pages.faq.list', compact('faqs'));
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    public function create() {
        return view('pages.faq.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'question' => 'required',
                'answer' => 'required',
                'type' => 'required|numeric',
            ],
            [
                'question.required' => 'Chưa nhập trường này',
                'answer.required' => 'Chưa nhập trường này',
                'type.required' => 'Chưa nhập trường này',
                'type.numeric' => 'Sai định dạng!',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $this->faq::create([
                'question' => $request->question,
                'answer' => $request->answer,
                'type' => $request->type,
            ]);

            return Redirect::route('admin.faq.list');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    public function edit(FrequentlyAskedQuestion $faq) {
        return view('pages.faq.edit', compact('faq'));
    }

    public function update(Request $request, FrequentlyAskedQuestion $faq)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'question' => 'required',
                'answer' => 'required',
                'type' => 'required|numeric',
            ],
            [
                'question.required' => 'Chưa nhập trường này',
                'answer.required' => 'Chưa nhập trường này',
                'type.required' => 'Chưa nhập trường này',
                'type.numeric' => 'Sai định dạng!',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $faq->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'type' => $request->type,
            ]);

            return Redirect::route('admin.faq.list');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    public function destroy(FrequentlyAskedQuestion $faq) {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $faq->delete();

            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**API for client */
    public function getListFAQ(Request $request, $type) {
        if ($type == 'internship') {
            $typeCode = 0;
        } else if ($type == 'job') {
            $typeCode = 1;
        } else if ($type == 'event') {
            $typeCode = 2;
        }
        $data = $this->getList($request)
            ->where('type', $typeCode)
            ->paginate(request('limit') ?? 12);

        if (!$data) abort(404);

        return $this->responseApi(true, $data);
    }

    public function apiDetail(FrequentlyAskedQuestion $faq)
    {
        if (!$faq) abort(404);
        $faq->increment('view');

        return $this->responseApi(true,$faq);
    }

    public function apiRelate(Request $request, FrequentlyAskedQuestion $faq)
    {
        $data = $this->getList($request)
            ->where('type', $faq->type)
            ->where('id', '<>', $faq->id)
            ->paginate(request('limit') ?? 6);
        
        return $this->responseApi(true, $data); 
    }
}
