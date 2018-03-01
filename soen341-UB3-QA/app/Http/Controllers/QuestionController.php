<?php

namespace App\Http\Controllers;

use App\question;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Reply;


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
        $this->validate($request, [
            'title' => 'required|unique:questions|max:255',
            'content' => 'required',
        ]);


        if(Auth::check()) {
            $question = new Question;
            $question->user_id = Auth::id();
            $question->title = $request->get('title');
            $question->content = $request->get('content');
            $question->Label_1 = $request->get('label_1');
            $question->Label_2 = $request->get('label_2');
            $question->save();

            return redirect('/home');
        }
        else
            return redirect('/ask');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$question = Question::find($id);
		$user = User::where('id', $question->user_id)->get();
		$replies = Reply::where('question_id', $id)->get();
		$qOwner = ($question->user_id == Auth::id());
        return view('question')->with('info', ['question'=>$question, 'user' => $user, 'replies'=>$replies, 'qOwner'=>$qOwner]);
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
