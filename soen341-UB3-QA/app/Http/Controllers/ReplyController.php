<?php

namespace App\Http\Controllers;

use App\reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id)
    {
		$this->validate(request(), [
            'body' => 'required'
        ]);
		
		$qid = $id;
        if(Auth::check()) {
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

    /**
     * Display the specified resource.
     *
     * @param  \App\reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(reply $reply)
    {
        //
    }
}
