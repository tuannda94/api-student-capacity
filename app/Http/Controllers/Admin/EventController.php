<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\RequestEvent;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use TUploadImage, TResponse;
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    private function getList(Request $request) 
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = $this->event::where('name', 'like', "%$keyword%")
            ->with(['createdBy', 'participants']);

        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        
        return $query;
    }

    public function index(Request $request) {
        try {
            $events = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
                
            return view('pages.events.list', compact('events'));
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    public function create() {
        return view('pages.events.create');
    }

    public function store(RequestEvent $request) {
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'created_by' => auth()->user()->id,
            ];
            $thumbnail = $this->uploadFile($request->file('thumbnail'));
            if (!$thumbnail)  return redirect()->back()->with('error', 'Thêm mới thất bại !');
            $data['thumbnail'] = $thumbnail;
            $this->event->create($data);
            
            return redirect()->route('admin.event.list');
        } catch (\Throwable $th) {
            return redirect('error');
        }
    }

    public function edit(Event $event) {
        return view('pages.events.edit', compact('event'));
    }

    public function update(Event $event, RequestEvent $request) {
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
            ];

            $thumbnail = $this->uploadFile($request->file('thumbnail'));
            if (!$thumbnail)  return redirect()->back()->with('error', 'Thêm mới thất bại !');
            $data['thumbnail'] = $thumbnail;
            $event->update($data);
            
            return redirect()->route('admin.event.list');
        } catch (\Throwable $th) {
            return redirect('error');
        }
    }

    public function destroy(Event $event) {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $event->delete();

            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(400);
        }
    }

    /**API for client */
    public function getListEvents(Request $request) {
        $data = $this->getList($request)
            ->paginate(20);

        if (!$data) abort(404);
        
        return $this->responseApi(true, $data);
    }

    public function apiDetailEvent(Event $event)
    {
        if (!$event) abort(404);
        $event->load(['participants']);

        return $this->responseApi(true, $event);
    }

}
