<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\FeedbackQuestion;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Feedback;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{

    public function feedbackQuestions()
    {
        //check permission
        //$this->authorize("_access");

        $feedbackQuestions = FeedbackQuestion::select('id', 'question')->get();
        return $this->josnResponse(true, "All Feedback questions.", Response::HTTP_OK, $feedbackQuestions);
    }

    public function feedbacks()
    {
        //check permission
        //$this->authorize("_access");

        $softwareDeptId = Department::where('name', 'like', '%software%')->first()->id;
        $softwareLecturers = Lecturer::with([
            'subjects' => function ($qeury) {
                $qeury->select( 'name')->first();
            }
        ])->where('dept_id', $softwareDeptId)->take(10)->get();

        return $softwareLecturers;

        $feedbacks = Feedback::query()->get();
        return $this->josnResponse(true, "All Submited Feedback.", Response::HTTP_OK, $feedbacks);
    }

    public function submitFeedback(Request $request)
    {
        //check permission
        //$this->authorize("_access");

        $validator = Validator::make($request->all(), [
            "lecturer_id" => ['required', 'exists:lecturers,id'],
            "subject_id" => ['required', 'exists:subjects,id'],
            "score_avg" => ['required', 'integer'],

        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        // get user 
        $user = $request->user();

        //check if user has role student
        if (!$user->hasRole('student')) {
            return $this->josnResponse(false, "You cann't submit feedback (you are not student).", Response::HTTP_FORBIDDEN);
        }


        //check if user belong to a depratment
        if (!$user->dept_id) {
            return $this->josnResponse(false, "Student is not belong to any department", Response::HTTP_BAD_REQUEST);
        }

        //check if user submited feedback this year
        $is_submited = $user->feedbacks()->where('feedback_year', getYear())->get();
        if (count($is_submited)) {
            return $this->josnResponse(false, "You already submited this year feedback", Response::HTTP_BAD_REQUEST);
        }

        Feedback::create([
            "std_id" => $user->id,
            "dept_id" => $user->dept_id,
            "lec_id" => $request->lecturer_id,
            "sub_id" => $request->subject_id,
            "score" => $request->score_avg,
            "feedback_year" => getYear(),
        ]);

        return $this->josnResponse(true, "Feedback submited successfully", Response::HTTP_CREATED);
    }

    public function deleteFeedback(Request $request)
    {
        // get user 
        $user = $request->user();

        //check if user has role student
        if (!$user->hasRole('student')) {
            return $this->josnResponse(false, "You can not delete feedback (you are not student).", Response::HTTP_FORBIDDEN);
        }

        //check if user submited feedback this year
        $is_submited = $user->feedbacks()->where('feedback_year', getYear())->get();
        if (!count($is_submited)) {
            return $this->josnResponse(false, "You didn't submit feedback this year", Response::HTTP_BAD_REQUEST);
        }

        $user->feedbacks()->where('feedback_year', getYear())->delete();

        return $this->josnResponse(true, "Feedback deleted successfully", Response::HTTP_OK);
    }

    public function report(Request $request)
    {
        //get avg of all student score for that lecturer

        return $this->josnResponse(true, "Feedback Report", Response::HTTP_OK);
    }
}
