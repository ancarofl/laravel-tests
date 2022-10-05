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
		$user = User::with('blockedusers')->findOrFail($request['user_id']);
		$blockedUserIds = $user->blockedusers()->get()->pluck('id');

		$users = User::select('*')
		->when(count($blockedUserIds)>0, function($query) use ($blockedUserIds)
				{
					$query->whereDoesntHave("blockedusers", function ($query) use ($blockedUserIds)
					{
						$query->whereIn("blocked_id",$blockedUserIds);
					});
				})
		->get();

		dd($users);
	}
}
