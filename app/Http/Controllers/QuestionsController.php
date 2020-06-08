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
        $answer = new Answer;
        $answer->description = $request->answer;
        $answer->question_id = $question->id;
        $answer->save();
        return response()->json($answer);
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
            'message'=> 'Question updated successfully'
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

    public function findQuestions($string)
    {
        $questions = DB::table('questions')
                ->where('description', 'like', '%'.$string.'%')
                ->get();

        return response()->json($questions); 
    }

    public function add($id)
    {
        $question = Question::find($id);
        $question->added = true;

        $question->save();

        return response()->json([
            'message'=> 'Question updated successfully',
            $question
        ]);
    }
}
