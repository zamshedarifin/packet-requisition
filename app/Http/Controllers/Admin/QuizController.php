<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Mark;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Symfony\Component\Console\Question\Question;

class QuizController extends Controller
{
    //
    public function quiz()
    {
        $quizzes = Quiz::latest('id')->paginate(15);
        return view('admin.quiz.quizIndex',compact('quizzes'));
    }

    /**
     Quiz create
    */
    public function quizCreate(Request $request)
    {
        if($request->isMethod('post'))
        {
           $request->validate([
               'title'=>'required',
               'about_quiz'=>'required',
               'terms_condition'=>'required',
               'instruction'=>'required',
               'start_date'=>'required',
               'end_date'=>'required',
               'quiz_duration'=>'required|numeric',
               'quiz_mark'=>'required|numeric',
               'thumbnail' => 'required|mimes:png,jpg,jpeg|max:1024',
               'status'=>'required',
           ]);
            $quizStore = new Quiz();
            $quizStore->title = $request->title;
            $quizStore->about_quiz = $request->about_quiz;
            $quizStore->terms_condition = $request->terms_condition;
            $quizStore->instruction = $request->instruction;
            $quizStore->start_date =date('Y-m-d H:i:s', strtotime($request->start_date));
            $quizStore->end_date =date('Y-m-d H:i:s', strtotime($request->end_date));
            $quizStore->quiz_duration = $request->quiz_duration;
            $quizStore->quiz_mark = $request->quiz_mark;
            if ($request->hasFile('thumbnail')) {
                $extension = $request->thumbnail->getClientOriginalExtension();
                $image = time() . '.' . $extension;
                $request->thumbnail->move(public_path('uploads/quiz/'), $image);
                $quizStore->thumbnail = $image;
            }
            $quizStore->status = $request->status;
            $quizStore->save();
            return back()->with('success','Quiz Added Successfully');
        }
        else
        {
            return view('admin.quiz.quizCreate');
        }
    }

    /**
    Quiz Update
     */
    public function quizUpdate(Request $request,$id)
    {
        if($request->isMethod('post'))
        {
            $request->validate([
                'title'=>'required',
                'about_quiz'=>'required',
                'terms_condition'=>'required',
                'instruction'=>'required',
                'start_date'=>'required',
                'end_date'=>'required',
                'quiz_duration'=>'required|numeric',
                'quiz_mark'=>'required|numeric',
                'thumbnail'=>'mimes:jpeg,jpg,png',
                'status'=>'required',
            ]);
            $quizUpdate = Quiz::findOrFail($id);
            $quizUpdate->title = $request->title;
            $quizUpdate->about_quiz = $request->about_quiz;
            $quizUpdate->terms_condition = $request->terms_condition;
            $quizUpdate->instruction = $request->instruction;
            $quizUpdate->start_date =date('Y-m-d H:i:s', strtotime($request->start_date));
            $quizUpdate->end_date =date('Y-m-d H:i:s', strtotime($request->end_date));
            $quizUpdate->quiz_duration = $request->quiz_duration;
            $quizUpdate->quiz_mark = $request->quiz_mark;
            if ($request->hasFile('thumbnail')) {
                $extension = $request->thumbnail->getClientOriginalExtension();
                $image = time() . '.' . $extension;
                $request->thumbnail->move(public_path('uploads/quiz/'), $image);
                $quizUpdate->thumbnail = $image;
            }
            $quizUpdate->status = $request->status;
            $quizUpdate->save();
            return back()->with('success','Quiz Updated Successfully');
        }
        else
        {
            $quizData = Quiz::findOrFail($id);
            return view('admin.quiz.quizUpdate',compact('quizData'));
        }
    }
    /**
    Quiz Results
    */
    public function QuizResults($id)
    {
       $results = Mark::where('quiz_id',$id)->orderBy('mark','desc')->orderBy('total_time','asc')->where('mark', '!=', '0')->paginate(25);
       $quiz= Quiz::findOrFail($id);
        return view('admin.quiz.quizResults',compact('results','quiz'));
    }

    /**
    Quiz Destroy (Delete Quiz)
    */
    public function QuizDestroy($id)
    {
        Quiz::destroy($id);
        return back()->with('success','Quiz Destroyed Successfully');
    }

    /**
    Quiz Answer
     */
    public function answerSheet($id)
    {
      $id= explode('-', unlock($id));
        //$id[0] = quiz id,
        //$id[1] = user id,

      $quiz=Quiz::findOrFail($id[0]);
      $answers= Answer::where('user_id',$id[1])->where('quiz_id',$id[0])->first();
//        dd($answers->details);
      return view('admin.quiz.answerSheet',compact('quiz','answers'));
    }

}
