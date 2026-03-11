<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class StatController extends Controller
{
    use TUploadImage, TResponse;
    private $stat;

    public function __construct(Stat $stat)
    {
        $this->stat = $stat;
    }

    public function index(Request $request) {
        try {
            $stats = $this->stat::paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
                
            return view('pages.stats.list', compact('stats'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create() {
        return view('pages.stats.create');
    }

    public function store(Request $request) {
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'value' => $request->value,
                'unit' => $request->unit,
            ];
            $icon = $this->uploadFile($request->file('icon'));
            if (!$icon)  return redirect()->back()->with('error', 'Thêm mới thất bại !');
            $data['icon'] = $icon;
            $this->stat->create($data);
            
            return redirect()->route('admin.stat.list')->with('success', 'Thêm thông số thành công');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function edit(Stat $stat) {
        return view('pages.stats.edit', compact('stat'));
    }

    public function update(Stat $stat, Request $request) {
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'value' => $request->value,
                'unit' => $request->unit,
                'icon' => $stat->icon,
            ];
            
            if ($request->file('icon') != null) {
                $icon = $this->uploadFile($request->file('icon'));
                if (!$icon) {
                    return redirect()->back()->with('error', 'Thêm mới thất bại !');
                } else {
                    $data['icon'] = $icon;
                }
            }
            $stat->update($data);
            
            return redirect()->route('admin.stat.list')->with('success', 'Sửa thông số thành công');;
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(stat $stat) {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $stat->delete();

            return redirect()->back()->with('success', 'Xóa thông số thành công');;
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**API for client */
    public function getListStats() {
        $data = $this->stat::where('status', config('util.ACTIVE_STATUS'))->limit(5)->get();

        if (!$data) abort(404);
        
        return $this->responseApi(true, $data);
    }
}
