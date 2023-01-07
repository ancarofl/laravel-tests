<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Mail\DailyReports;
use Illuminate\Support\Facades\Mail;

class DebugController extends Controller
{
	public function sendMail()
	{
		Mail::to('tomail@gmail.com')->send(new DailyReports);
	}
}