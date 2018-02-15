<?php

namespace App\Http\Controllers;

use App\question;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question_data = DB::table('questions')->join('users','users.id','=','questions.user_id')
        ->select('questions.id','questions.title', 'questions.content', 'questions.user_id', 'questions.created_at','questions.updated_at', 'users.name')
        ->get();

        return view('welcome', ['question_data' => $question_data]);
    }

    //search function of home page
    public function search()
    {
        //user input taken from search form
        $search = Request::get('search');

        //taking all the questions that have the search term in their title
        $question_data = Question::where('title', 'LIKE', '%'.$search.'%')
            ->join('users','users.id','=','questions.user_id')->get();

        return view('welcome', ['question_data' => $question_data]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(question $question)
    {
        //
    }
}
