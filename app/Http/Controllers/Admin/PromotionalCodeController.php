<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class PromotionalCodeController extends Controller
{
    public function index()
    {
        dd("Controller index");
    }

    public function create()
    {
        dd("Controller create");
    }

    public function store(Request $request)
    {
        dd("Controller store");
    }

    public function show($id)
    {
        dd("Controller show");
    }

    public function edit($id)
    {
		dd("Controller edit");
    }

    public function update(Request $request, $id)
    {
        dd("Controller update");
    }

    public function destroy($id)
    {
        dd("Controller destroy");
    }
}
