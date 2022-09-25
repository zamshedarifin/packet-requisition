<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QuestionImport;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    public function quizQuestion($id)
    {
        $previousUrl = URL::previous();
        $quiz = Quiz::findOrFail($id);
        $questions = QuizQuestion::orderBy('id', 'desc')->where('quiz_id', $id)->paginate(15);
        return view("admin.question.index", compact('questions', 'quiz', 'previousUrl'));
    }

    public function questionCreate($id, Request $request)
    {
        if ($request->isMethod('POST')) {
            if ($request->question_type == 1) {
                $request->validate([
                    'question_type' => 'required|numeric',
                    'question' => 'required|max:400',
                    'option_one' => "required|max:300",
                    'option_two' => "required|max:300",
                    'option_three' => "required|max:300",
                    'option_four' => "required|max:300",
                    'answer' => 'required',
                ]);
                $question = new QuizQuestion();
                $question->quiz_id = $id;
                $question->question = $request->question;
                $question->option_one = $request->option_one;
                $question->option_two = $request->option_two;
                $question->option_three = $request->option_three;
                $question->option_four = $request->option_four;
                $question->answer = $request->answer[1];
                $question->q_type = $request->question_type == 1 ? 1 : 2;
                $question->save();

                //auto update total question
                $quiz=Quiz::where('id',$id)->first();
                if($quiz->total != 'null'){
                    $quiz->update(['total' => $quiz->total+1]);
                }
                else
                {
                    $quiz->update(['total' => 1]);
                }

            } elseif ($request->question_type == 2) {
                $request->validate([
                    'question_type' => 'required|numeric',
                    'img_question' => 'required|max:400',
                    'image_one' => "required|max:200|mimes:jpg,jpeg,png",
                    'image_two' => "required|max:200|mimes:jpg,jpeg,png",
                    'image_three' => "required|max:200|mimes:jpg,jpeg,png",
                    'image_four' => "required|max:200|mimes:jpg,jpeg,png",
                    'answer' => 'required',
                ]);
                $question = new QuizQuestion();
                $question->quiz_id = $id;
                $question->question = $request->img_question;
                if ($request->hasFile('image_one')) {
                    $extension = $request->image_one->getClientOriginalExtension();
                    $imageOne = time() . Str::random(14) . '.' . $extension;
                    $request->image_one->move(public_path('uploads/question/'), $imageOne);
                    $question->option_one = $imageOne;
                }
                if ($request->hasFile('image_two')) {
                    $extension = $request->image_two->getClientOriginalExtension();
                    $imageTwo = time() . Str::random(14) . '.' . $extension;
                    $request->image_two->move(public_path('uploads/question/'), $imageTwo);
                    $question->option_two = $imageTwo;
                }
                if ($request->hasFile('image_three')) {
                    $extension = $request->image_three->getClientOriginalExtension();
                    $imageThree = time() . Str::random(14) . '.' . $extension;
                    $request->image_three->move(public_path('uploads/question/'), $imageThree);
                    $question->option_three = $imageThree;
                }
                if ($request->hasFile('image_four')) {
                    $extension = $request->image_four->getClientOriginalExtension();
                    $imageFour = time() . Str::random(14) . '.' . $extension;
                    $request->image_four->move(public_path('uploads/question/'), $imageFour);
                    $question->option_four = $imageFour;
                }
                $question->q_type = 2;
                $question->answer = $request->answer[1];
                $question->save();

                //auto update total question
                $quiz=Quiz::where('id',$id)->first();
                if($quiz->total != 'null'){
                    $quiz->update(['total' => $quiz->total+1]);
                }
                else
                {
                    $quiz->update(['total' => 1]);
                }
            } else {
                $request->validate([
                    'question_type' => 'required|numeric',
                ]);
            }
            return redirect()->back()->with('success', 'Quiz Question has been added successfully.');
        } else {
            return view('admin.question.create');
        }
    }


    public function questionUpdate(Request $request, $id)
    {
        $question = QuizQuestion::findOrFail($id);
        $previousUrl = URL::previous();
        if ($request->isMethod('POST')) {
            if ($question->q_type == 2) {
                $request->validate([
                    'question' => 'required|max:400',
                    'image_one' => "nullable|max:200|mimes:jpg,jpeg,png",
                    'image_two' => "nullable|max:200|mimes:jpg,jpeg,png",
                    'image_three' => "nullable|max:200|mimes:jpg,jpeg,png",
                    'image_four' => "nullable|max:200|mimes:jpg,jpeg,png",
                    'answer' => 'required',
                ]);
                $ques = QuizQuestion::findOrFail($id);
                $ques->question = $request->question;
                if ($request->hasFile('image_one')) {
                    $extension = $request->image_one->getClientOriginalExtension();
                    $imageOne = time() . Str::random(14) . '.' . $extension;
                    $request->image_one->move(public_path('uploads/question/'), $imageOne);
                    $ques->option_one = $imageOne;
                }
                if ($request->hasFile('image_two')) {
                    $extension = $request->image_two->getClientOriginalExtension();
                    $imageTwo = time() . Str::random(14) . '.' . $extension;
                    $request->image_two->move(public_path('uploads/question/'), $imageTwo);
                    $ques->option_two = $imageTwo;
                }
                if ($request->hasFile('image_three')) {
                    $extension = $request->image_three->getClientOriginalExtension();
                    $imageThree = time() . Str::random(14) . '.' . $extension;
                    $request->image_three->move(public_path('uploads/question/'), $imageThree);
                    $ques->option_three = $imageThree;
                }
                if ($request->hasFile('image_four')) {
                    $extension = $request->image_four->getClientOriginalExtension();
                    $imageFour = time() . Str::random(14) . '.' . $extension;
                    $request->image_four->move(public_path('uploads/question/'), $imageFour);
                    $ques->option_four = $imageFour;
                }
                $ques->answer = $request->answer[1];
                $ques->save();
            } else {
                $request->validate([
                    'question' => 'required|max:400',
                    'option_one' => "required|max:300",
                    'option_two' => "required|max:300",
                    'option_three' => "required|max:300",
                    'option_four' => "required|max:300",
                    'answer' => 'required',
                ]);
                $ques = QuizQuestion::findOrFail($id);
                $ques->question = $request->question;
                $ques->option_one = $request->option_one;
                $ques->option_two = $request->option_two;
                $ques->option_three = $request->option_three;
                $ques->option_four = $request->option_four;
                $ques->answer = $request->answer[1];
                $ques->save();
            }
            return redirect()->back()->with('success', 'Quiz Question has been updated successfully.');
        }
        return view("admin.question.update", compact('question', 'previousUrl'));
    }

    public function questionImport($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'file' => 'required',
            ]);
            $data = array();
            $rows = Excel::toArray(new QuestionImport(), $request->file('file'));
            foreach ($rows as $value) {
                foreach ($value as $arr) {
                    //value from custom input field
                    $data['quiz_id'] = $id;
                    $data['q_type'] = 1;
                    //Value Receive from excel sheet
                    $data['question'] = $arr['question'];
                    $data['option_one'] = $arr['option_one'];
                    $data['option_two'] = $arr['option_two'];
                    $data['option_three'] = $arr['option_three'];
                    $data['option_four'] = $arr['option_four'];
                    $data['answer'] = $arr['answer'];
                    QuizQuestion::create($data);

                    //auto update total question
                    $quiz=Quiz::where('id',$id)->first();
                    if($quiz->total != 'null'){
                        $quiz->update(['total' => $quiz->total+1]);
                    }
                    else
                    {
                        $quiz->update(['total' => 1]);
                    }
                }

            }
            return redirect()->back()->with('success', 'Quiz Question has been added successfully.');
        } else {
            return view('admin.question.questionImport');
        }
    }
}
