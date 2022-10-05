<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class TestController extends Controller
{
    public function block(Request $request) {
		$user = User::with('blockedusers')->findOrFail($request['reporter_id']);

        $blocked_id = $request['reported_id'];
    
        $user->blockedusers()->attach($blocked_id);

		$blockedUserIds = $user->blockedusers()->get()->pluck('id');

		return back();
	}

	public function blocked(Request $request) {
		$user = User::with('blockedusers')->findOrFail($request['user_id']);

		$blockedUserIds = $user->blockedusers()->get()->pluck('id');
		dd($blockedUserIds);
	}

	public function unblocked(Request $request) {
		$user = User::findOrFail($request['user_id']);
		$blockedUserIds = $user->blockedusers()->get()->pluck('id');
		
		count($blockedUserIds) ? $users = User::whereNot('id',$user->id)->whereNotIn('id', $blockedUserIds)->get() : $users = User::whereNot('id',$user->id)->get();
		
		// dd($users);
		return view('result', [
			'users' => $users, 
		]);
	}
}
