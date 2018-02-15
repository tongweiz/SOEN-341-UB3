<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\question;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    //search function of home page
    public function search(Request $request)
    {
        //user input taken from search form
        $search = Request::get('search');

        //taking all the questions that have the search term in their title
        $question_data = Question::where('title', 'LIKE', '%'.$search.'%')
            ->join('users','users.id','=','questions.user_id')->get();

        return view('welcome', ['question_data' => $question_data]);
    }
}
