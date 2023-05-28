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
    public function index(){
        $this->checkTypeContest();
        if (!($data = $this->subject->ListSubject())) return abort(404);

        return view('pages.subjects.index', [
            'subjects' => $data
        ]);
    }

    private function checkTypeContest()
    {
        if (request('type') != config('util.TYPE_CONTEST') && request('type') != config('util.TYPE_TEST')) abort(404);
    }
}
