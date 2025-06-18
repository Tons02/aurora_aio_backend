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
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');

        $checklist = Checklist::with('sections.questions.answers')
            ->when($status === "inactive", function ($query) {
                $query->onlyTrashed();
            })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('Checklist display successfully', $checklist);
    }

    public function store(ChecklistRequest $request)
    {
        DB::beginTransaction(); // Start the transaction

        try {

            // Create checklist
            $checklist = Checklist::create([
                "title" => $request->title,
                "description" => $request->description,
            ]);

            $section = Section::create([
                "title" => null,
                "description" => null,
                "point_per_item" => null,
                "total_points" => null,
                "checklist_id" => $checklist->id,
            ]);

            $question = Question::create([
                "title" => null,
                "description" => null,
                "type" => null,
                "required" => null,
                "section_id" => $section->id,
            ]);

            Answer::create([
                "title" => null,
                "points" => null,
                "question_id" => $question->id,
            ]);

            DB::commit();
            return $this->responseCreated('Checklist Successfully Created');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseServerError('Network Error Please Try Again');
        }
    }

    public function update(ChecklistRequest $request)
    {
        DB::beginTransaction();

        try {
            $checklistData = $request->checklist;

            // Update or Create Checklist
            $checklist = Checklist::updateOrCreate(
                ['id' => $checklistData['id']],
                [
                    'title' => $checklistData['title'],
                    'description' => $checklistData['description'],
                ]
            );

            // Keep track of section/question/answer IDs to avoid deleting them
            $sectionIds = [];
            $questionIds = [];
            $answerIds = [];

            foreach ($checklistData['sections'] as $sectionData) {
                $section = Section::updateOrCreate(
                    ['id' => $sectionData['id'] ?? null],
                    [
                        'title' => $sectionData['title'],
                        'description' => $sectionData['description'],
                        'point_per_item' => $sectionData['point_per_item'],
                        'total_points' => $sectionData['total_points'],
                        'checklist_id' => $checklist->id,
                    ]
                );

                $sectionIds[] = $section->id;

                foreach ($sectionData['questions'] as $questionData) {
                    $question = Question::updateOrCreate(
                        ['id' => $questionData['id'] ?? null],
                        [
                            'title' => $questionData['title'],
                            'description' => $questionData['description'],
                            'type' => $questionData['type'],
                            'required' => $questionData['required'],
                            'section_id' => $section->id,
                        ]
                    );

                    $questionIds[] = $question->id;

                    foreach ($questionData['answers'] as $answerData) {
                        $answer = Answer::updateOrCreate(
                            ['id' => $answerData['id'] ?? null],
                            [
                                'title' => $answerData['title'],
                                'points' => $answerData['points'],
                                'question_id' => $question->id,
                            ]
                        );

                        $answerIds[] = $answer->id;
                    }

                    // Soft delete answers not included
                    Answer::where('question_id', $question->id)
                        ->whereNotIn('id', $answerIds)
                        ->delete();
                }

                // Soft delete questions not included
                Question::where('section_id', $section->id)
                    ->whereNotIn('id', $questionIds)
                    ->delete();
            }

            // Soft delete sections not included
            Section::where('checklist_id', $checklist->id)
                ->whereNotIn('id', $sectionIds)
                ->delete();

            DB::commit();
            return $this->responseCreated('Checklist Successfully Updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseServerError('Network Error Please Try Again');
        }
    }
}
