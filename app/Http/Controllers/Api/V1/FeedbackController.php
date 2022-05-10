<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\FeedbackQuestion;
use App\Http\Controllers\Controller;
use App\Models\Feedaback;
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

    public function submitFeedback(Request $request)
    {
        //check permission
        //$this->authorize("_access");

        $validator = Validator::make($request->all(), [
            "student_id" => ['required', 'exists:students,id'],
            "dept_is" => ['required', 'exists:departments,id'],
            "lecturer_id" => ['required', 'exists:lecturers,id'],
            "subject_id" => ['required', 'exists:subjects,id'],
            "score_avg" => ['required', 'integer'],

        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        //check if user submited feedback this year
        //get feedback year

        Feedaback::create([
            "std_id" => $request->student_id,
            "lec_id" => $request->lecturer_id,
            "sub_id" => $request->subject_id,
            "dept_id" => $request->dept_id,
            "score" => $request->score_avg,
            "result" => $request->null,
            "status" => $request->null,
            "feedback_year" => $request->null,
        ]);

        return $this->josnResponse(true, "Feedback submited successfully", Response::HTTP_CREATED);
    }
}
