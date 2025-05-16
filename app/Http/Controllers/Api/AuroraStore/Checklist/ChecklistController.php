<?php

namespace App\Http\Controllers\Api\AuroraStore\Checklist;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuroraStore\Checklist\ChecklistRequest;
use App\Models\AuroraStore\Checklist\Answer;
use App\Models\AuroraStore\Checklist\Checklist;
use App\Models\AuroraStore\Checklist\Question;
use App\Models\AuroraStore\Checklist\Section;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');

        $checklist = Checklist::when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('Store display successfully', $checklist);
    }

    public function store(ChecklistRequest $request)
    {
        $create_checklist = Checklist::create([
            "title" => $request->title,
            "description" => $request->description,
        ]);

        $create_section = Section::create([
            "title" => null,
            "description" => null,
            "point_per_item" => null,
            "total_points" => null,
        ]);

        return $create_checklist->sections()->attach($create_section->id);



        $create_question = Question::create([
            "title" => null,
            "description" => null,
            "type" => null,
            "required" => null,
        ]);

        and i want to get the id of checklist and also sync

        $create_answer = Answer::create([
            "title" => null,
            "description" => null,
            "points" => null,
        ]);

        return $this->responseCreated('Checklist Successfully Created');
    }
}
