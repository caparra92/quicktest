<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Question;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();

        return response()->json($questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question;
        $question->course = $request->course;
        $question->description = $request->description;
        $question->type = $request->type;
        $question->level = $request->level;
        $question->user_id = $request->user_id;
        $question->save();
        $answers = json_decode($request->answers, true);

        foreach ($answers as $answer) {
            $ans = new Answer();
            $ans->letter = $answer['letter'];
            $ans->description = $answer['option'];
            $ans->is_correct = $answer['is_correct'];
            $ans->question_id = $question->id;
            $ans->save();
        }

        /* $answer = new Answer;
        $answer->description = $request->answer;
        $answer->question_id = $question->id;
        $answer->save(); */
        return response()->json('Question saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::find($id);

        $question->name = $request->name;
        $question->description = $request->description;
        $question->type = $request->type;
        $question->level = $request->level;
        $question->added = $request->added;
        //$question->user_id = Auth::user()->id;

        $question->save();

        return response()->json([
            'message' => 'Question updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);

        $question->delete();
    }

    public function findQuestions($string, $type = '')
    {
        $type = json_decode($type);

       if ($type == [] || count($type) > 1) {
        $questions = DB::table('questions')
        ->where('description', 'like', '%' . $string . '%')
        ->get();
       } else {
        $questions = DB::table('questions')
        ->where('description', 'like', '%' . $string . '%')
        ->where('type', '=', $type)
        ->get();
       }
        foreach ($questions as $key => $question) {
            $answers = DB::table('answers')
                ->where('question_id', '=', $question->id)
                ->join('questions', 'questions.id', '=', 'answers.question_id')
                ->select('answers.letter', 'answers.description', 'answers.is_correct')
                ->get();
            $question->answers = $answers;
        }
        return response()->json($questions);
    }

    public function add($id)
    {
        $question = Question::find($id);
        $question->added = true;

        $question->save();

        $answers = DB::table('answers')
            ->where('question_id', '=', $question->id)
            ->join('questions', 'questions.id', '=', 'answers.question_id')
            ->select('answers.letter', 'answers.description', 'answers.is_correct')
            ->get();

        $question->answers = $answers;

        return response()->json([
            'message' => 'Question updated successfully',
            $question
        ]);
    }

    public function remove($id)
    {
        $question = Question::find($id);
        $question->added = false;

        $question->save();

        return response()->json([
            'message' => 'Question updated successfully',
            $question
        ]);
    }
}
