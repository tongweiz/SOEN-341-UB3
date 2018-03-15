<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Return view with user information
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all information of that particular user
        $userinfo = DB::table("users")->where("users.id", "=", Auth::id())->get();

        //get all questions asked by the logged in user
        $questioninfo = DB::table('questions')->join('users', 'users.id', '=', 'questions.user_id')->where("questions.user_id", "=", Auth::id())
            ->select('questions.id', 'questions.title', 'questions.content', 'questions.nb_replies', 'questions.labels',
                'questions.user_id', 'questions.created_at', 'questions.updated_at', 'users.name')
            ->get();

        //return info to view
        return view('profile', ['user_info' => $userinfo, 'question_data' => $questioninfo]);
    }

    /**
     * Saves the new values for the user
     */
    public function edit(Request $request)
    {
        //get all data from post ajax query
        $data = $request->all();

        //find specific user row in db
        $user = User::findOrFail($data['id']);

        //check if password needs to be updated and do it
        if ($_POST['password'] != null)
            $user->password = bcrypt($data['password']);

        //update user with new info
        $user->name = $data['name'];
        $user->email = $data['email'];

        //save changes i did to user
        $user->save();
    }
}
