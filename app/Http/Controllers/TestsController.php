<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Test;
use App\Question;
use PDF;
use Illuminate\Support\Facades\App;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::all();

        return response()->json($tests);
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
        $request->validate([
            'title' => 'required|string',
            'course' => 'required|string',
            'signature' => 'required|int',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $questions = json_decode($request->questions);
        $test = new Test;
        $test->title = $request->title;
        $test->course = $request->course;
        $test->description = $request->description;
        $test->date = $request->date;
        $test->user_id = $request->user_id;
        $test->category_id = $request->category_id;

        $test->save();

        foreach ($questions as $key => $question) {
            $question_test = DB::table('question_test')
                ->insert([
                    ['test_id' => $test->id, 'question_id' => $question->id]
                ]);
            $quest = Question::find($question->id);
            $quest->added = false;
            $quest->save();
        }

        return response()->json([
            'message' => 'Test added successfully',
            'test'=> $test,
            'questions' => $quest
        ]);
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
        $test = Test::find($id);

        $test->name = $request->name;
        $test->description = $request->description;
        $test->user_id = $request->user_id;
        $test->category_id = $request->category_id;

        $test->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $test = Test::find($id);

        $test->delete();
    }

    public function createTest()
    {
        //crear nuevo test
    }

    public function addQuestionTest()
    {
        //adicionar preguntas al test
    }

    public function printTest($id)
    {
        $test = Test::find($id);
        $user_name = DB::table('tests')
                ->where('user_id', '=', $test->user_id)
                ->join('users', 'users.id', '=', 'tests.user_id')
                ->select('users.name')
                ->first();
        $signature = DB::table('tests')
                ->where('category_id', '=', $test->category_id)
                ->join('categories', 'categories.id', '=', 'tests.category_id')
                ->select('categories.name')
                ->first();
        $pdf = PDF::loadView('test', compact('test','user_name','signature'));
        return $pdf->download('test.pdf')->header('Content-type','application/pdf');
        
    }
}
