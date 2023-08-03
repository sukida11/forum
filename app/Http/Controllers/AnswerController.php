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

    public function update(UpdateRequest $request, Answer $answer): \Illuminate\Http\RedirectResponse
    {

        if ($answer->checkUserToEditAnswer()) $answer->update($request->validated());

        return redirect()->back();
    }

    public function destroy(Answer $answer)
    {
        $theme_id = $answer->thread->id;

        if ($answer->checkUserToEditAnswer()) $answer->delete();

        return redirect()->route('thread.show', ['thread' => $theme_id]);

    }

}
