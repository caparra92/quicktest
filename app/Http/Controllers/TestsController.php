<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;

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
        $test = new Test;
        $test->title = $request->title;
        $test->course = $request->course;
        $test->description = $request->description;
        $test->date = $request->date;
        $test->user_id = $request->user_id;
        $test->category_id = $request->category_id;

        $test->save();

        return response()->json($test);
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
}
