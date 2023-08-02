<?php

namespace App\Http\Controllers;

use App\Http\Requests\Answer\StoreRequest;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(StoreRequest $request)
    {
        Answer::create($request->validated());
        return redirect()->back();
    }
}
