<?php

namespace App\Http\Controllers;

use App\reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $qid = $id;
        if (Auth::check()) {
            $reply = new reply;
            $reply->question_id = $qid;
            $reply->user_id = Auth::id();
            $reply->content = request('body');
            $reply->likectr = 0;
            $reply->dislikectr = 0;
            $reply->status = 0;

            $reply->save();
        }
        return redirect("question/$qid");
    }
}
