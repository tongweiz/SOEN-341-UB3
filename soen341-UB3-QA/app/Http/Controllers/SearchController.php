<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Question;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //search function of home page
    public function search(Request $request)
    {
        //user input taken from search form
        $search = Request::get('search');

        //taking all the questions that have the search term in their title
        $question_data = Question::where('title', 'LIKE', '%' . $search . '%')
            ->join('users', 'users.id', '=', 'questions.user_id')->get();

        $label_data = DB::table('questions')->join('users', 'users.id', '=', 'questions.user_id')
            ->select('questions.id', 'questions.title', 'questions.content', 'questions.nb_replies',
                'questions.labels', 'questions.user_id', 'questions.created_at', 'questions.updated_at', 'users.name')
            ->get();

        return view('welcome', ['question_data' => $question_data, 'label_data' => $label_data, 'background_color_label' => '', 'label_clicked' => '']);
    }
}
