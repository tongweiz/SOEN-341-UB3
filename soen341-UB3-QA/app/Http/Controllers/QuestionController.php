<?php

namespace App\Http\Controllers;

use App\question;
use App\User;
use App\Like;
use App\Dislike;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
        //get question data
        $question_data = DB::table('questions')->join('users', 'users.id', '=', 'questions.user_id')
            ->select('questions.id', 'questions.title', 'questions.content', 'questions.user_id', 'questions.nb_replies', 'questions.created_at', 'questions.updated_at', 'users.name')
            ->get();

        //return view with necessary information
        return view('welcome', ['question_data' => $question_data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:questions|max:255',
            'content' => 'required',
        ]);


        if (Auth::check()) {
            $question = new Question;
            $question->user_id = Auth::id();
            $question->title = $request->get('title');
            $question->content = $request->get('content');
            $question->nb_replies = 0;

            //make sure labels have a value
            if ($request->get('labels') == null)
                $question->labels = '';
            else
                $question->labels = $request->get('labels');

            $question->save();

            return redirect('/home');
        } else
            return redirect('/ask');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\question $question
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get necessary data from db to display
        $question = Question::find($id);
        $user = User::where('id', $question->user_id)->get();
        $replies = Reply::where('question_id', $id)->get();
        $qOwner = ($question->user_id == Auth::id());
        $likes = Like::where('question_id', $id)->get();
        $dislikes = Dislike::where('question_id', $id)->get();

        return view('question')->with('info',
            ['question' => $question, 'user' => $user, 'replies' => $replies, 'qOwner' => $qOwner, 'likes' => $likes, 'dislikes' => $dislikes]);
    }
}
