<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentorInfo;
use App\Models\User;
use App\Services\Traits\TResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class MentorController extends Controller
{
    use TResponse;
    protected $mentor;
    protected $mentorInfo;

    public function __construct(User $mentor, MentorInfo $mentorInfo, Role $role)
    {
        $this->mentor = $mentor;
        $this->mentorInfo = $mentorInfo;
    }

    private function getList(Request $request) 
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = $this->mentor::where('name', 'like', "%$keyword%")
            ->whereHas('roles', function (Builder $query) {
                $query->where('id', config('util.MENTOR_ROLE'));
            })
            ->with('info');

        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        
        return $query;
    }

    public function index(Request $request) {
        try {
            $mentors = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            $availableMentors = $this->mentor::select('id', 'name', 'email')
                ->where('status', 1)
                ->whereDoesntHave('roles', function (Builder $query) {
                    $query->whereIn('id', [config('util.MENTOR_ROLE'), config('util.SUPER_ADMIN_ROLE'), config('util.ADMIN_ROLE')]);
                })
                ->get();

            return view('pages.mentors.list', compact('mentors', 'availableMentors'));
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    public function addMentors(Request $request)
    {
        try {
            $request->validate([
                'mentor_ids' => 'required|array',
                'mentor_ids.*' => 'exists:users,id'
            ]);
            $role = Role::find(config('util.MENTOR_ROLE'));
            foreach ($request->mentor_ids as $mentorId) {
                $user = $this->mentor::find($mentorId);
                $user->syncRoles($role->name);
            }

            return back()->with('success', 'Thêm doanh nghiệp thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function saveInfo(Request $request)
    {
        try {
            $this->mentorInfo::updateOrCreate(
                ['mentor_id' => $request->mentor_id],
                [
                'location' => $request->location,
                'experience' => $request->experience,
                'education' => $request->education,
                'position' => $request->position,
                'note' => $request->note,
            ]);
    
            return back()->with('success', 'Cập nhật thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }

    // public function destroy(MentorInfo $mentorInfo) {
    //     try {
    //         if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
    //         $mentorInfo->delete();

    //         return redirect()->back();
    //     } catch (\Throwable $th) {
    //         return redirect('error');
    //     }
    // }
}
