<?php

namespace App\Http\Controllers;

use App\reply;
use App\question;
use App\like;
use App\dislike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($rid)
    {
		$reply = Reply::find($rid);

        if(Auth::check()) {
			$liked = Like::where(['reply_id' => $rid, 'user_id' => Auth::id()])->get();
			if(count($liked) == 0){
				$reply->likectr += 1;
				$reply->save();

				$like = new like;
				$like->reply_id = $rid;
				$like->user_id = Auth::id();

				$like->save();
			}
		}

		return "$reply->likectr";
    }
	
	public function dislike($rid)
    {
		$reply = Reply::find($rid);

		if(Auth::check()) {
			$reply->dislikectr += 1;
			$reply->save();
		}
		
		return "$reply->dislikectr";
    }
	
	public function accept($rid)
	{
		$reply = Reply::find($rid);
		if(Auth::check()) {
			$question = Question::find($reply->question_id);
			if(Auth::id() == $question->user_id){
				$reply->status = 1;
				$reply->save();
			}
		}
		return redirect("question/$reply->question_id");
	}
	
	public function reject($rid)
	{
		$reply = Reply::find($rid);
		if(Auth::check()) {
			$question = Question::find($reply->question_id);
			if(Auth::id() == $question->user_id){
				$reply->status = -1;
				$reply->save();
			}
		}
		return redirect("question/$reply->question_id");
	}
	
	public function normalize($rid)
	{
		$reply = Reply::find($rid);
		if(Auth::check()) {
			$question = Question::find($reply->question_id);
			if(Auth::id() == $question->user_id){
				$reply->status = 0;
				$reply->save();
			}
		}
		return redirect("question/$reply->question_id");
	}
}
