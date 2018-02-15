<?php

namespace App\Http\Controllers;

use App\reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($rid)
    {
        if(Auth::check()) {
			$reply = Reply::find($rid);
			$reply->likectr += 1;
			
			$reply->save();
		}
		
		return redirect("question/$reply->question_id");
    }
	
	public function dislike($rid)
    {
		if(Auth::check()) {
			$reply = Reply::find($rid);
			$reply->dislikectr += 1;
			
			$reply->save();
		}
		
		return redirect("question/$reply->question_id");
    }
}
