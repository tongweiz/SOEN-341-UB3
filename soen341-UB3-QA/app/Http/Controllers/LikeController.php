<?php

namespace App\Http\Controllers;

use App\reply;
use App\question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($rid)
    {
		$reply = Reply::find($rid);
        if(Auth::check()) {
			$reply->likectr += 1;
			
			$reply->save();
		}
		
		return redirect("question/$reply->question_id");
    }
	
	public function dislike($rid)
    {
		$reply = Reply::find($rid);
		if(Auth::check()) {
			$reply->dislikectr += 1;
			
			$reply->save();
		}
		
		return redirect("question/$reply->question_id");
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
