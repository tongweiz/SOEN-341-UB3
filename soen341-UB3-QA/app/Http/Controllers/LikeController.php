<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Question;
use App\Like;
use App\Dislike;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($rid)
    {
        $reply = Reply::find($rid);

        //only authenticated users can like replies
        if (Auth::check()) {
            //checks if user is the same as the one who posted the reply
            if(Auth::id() == $reply->user_id)
                return "##";
            else {
                    $liked = Like::where(['reply_id' => $rid, 'user_id' => Auth::id()])->get();

                    //only save like if user didnt like this reply yet
                    if (count($liked) == 0) {

                                $disliked = Dislike::where(['reply_id' => $rid, 'user_id' => Auth::id()])->get();

                                //if the user already disliked this reply, decrement dislike
                                if (count($disliked) != 0) {
                                    $disliked[0]->delete();
                                    $reply->dislikectr -= 1;
                                }

                                //increment like counter of reply
                                $reply->likectr += 1;
                                $reply->save();

                                //make a new like row in the database
                                $like = new like;
                                $like->reply_id = $rid;
                                $like->user_id = Auth::id();
                                $like->question_id = $reply->question_id;
                                try {
                                    $like->save();
                                } catch (Exception $e) {
                                    return $e->getMessage();
                                }
                    }

                    //return new number of like and dislike of that reply for display
                    return "$reply->likectr.$reply->dislikectr";
            }
        } else {
            //no changes.
            return "#";
        }
    }

    public function dislike($rid)
    {
        $reply = Reply::find($rid);

        //only authenticated users can dislike replies
        if (Auth::check()) {
            //checks if user is the same the the one who posted the reply
            if(Auth::id() == $reply->user_id)
                return "##";
            else {
                    $disliked = Dislike::where(['reply_id' => $rid, 'user_id' => Auth::id()])->get();

                    //only save dislike if user didnt dislike this reply yet
                    if (count($disliked) == 0) {

                                $liked = Like::where(['reply_id' => $rid, 'user_id' => Auth::id()])->get();

                                //if the user already liked this reply, decrement like
                                if (count($liked) != 0) {
                                    $liked[0]->delete();
                                    $reply->likectr -= 1;
                                }

                                //increment dislike counter of reply
                                $reply->dislikectr += 1;
                                $reply->save();

                                //make a new dislike row in the database
                                $dislike = new dislike;
                                $dislike->reply_id = $rid;
                                $dislike->user_id = Auth::id();
                                $dislike->question_id = $reply->question_id;
                                try {
                                    $dislike->save();
                                } catch (Exception $e) {
                                    return $e->getMessage();
                                }
                    }

                    //return new number of like and dislike of that reply for display
                    return "$reply->likectr.$reply->dislikectr";
            }
        } else {
            //no changes
            return "#";
        }
    }

    public function accept($rid)
    {
        $reply = Reply::find($rid);

        if (Auth::check()) {
            $question = Question::find($reply->question_id);
            if (Auth::id() == $question->user_id) {
                $reply->status = 1;
                $reply->save();
                return "$reply->status";
            }
        }

        return "#";
    }

    public function reject($rid)
    {
        $reply = Reply::find($rid);

        if (Auth::check()) {
            $question = Question::find($reply->question_id);
            if (Auth::id() == $question->user_id) {
                $reply->status = -1;
                $reply->save();
                return "$reply->status";
            }
        }

        return "#";
    }

    public function normalize($rid)
    {
        $reply = Reply::find($rid);

        if (Auth::check()) {
            $question = Question::find($reply->question_id);
            if (Auth::id() == $question->user_id) {
                $reply->status = 0;
                $reply->save();
                return "$reply->status";
            }
        }

        return "#";
    }
}
