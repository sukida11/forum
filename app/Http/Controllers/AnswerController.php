<?php

namespace App\Http\Controllers;

use App\Http\Requests\Answer\StoreRequest;
use App\Http\Requests\Answer\UpdateRequest;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(StoreRequest $request)
    {
        Answer::create($request->validated());
        return redirect()->back();
    }

    public function update(UpdateRequest $request, Answer $answer)
    {

        $user = auth()->user();

        if ($answer->checkUserToEditAnswer()) return redirect()->back();
        $answer->update($request->validated());
        return redirect()->back();
    }
}
