<?php

namespace App\Http\Controllers;

use App\Http\Requests\Thread\UpdateRequest;
use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Requests\Thread\StoreRequest;
use Inertia\Inertia;
use JetBrains\PhpStorm\NoReturn;

class ThreadController extends Controller
{

    protected function checkThreadAccess($thread) : bool
    {
        return auth()->user()->id !== $thread->user_id && auth()->user()->role_id !== 'admin';
    }

    public function index()
    {

    }

    public function show(Thread $thread): \Inertia\Response
    {

        return Inertia::render('Threads/Show', [
            'thread' => $thread,
            'theme' => $thread->theme,
            'answers' => $thread->answers
        ]);

    }

    public function store(StoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        Thread::create($request->validated());
        return redirect()->back();
    }

    public function edit(Thread $thread): \Inertia\Response|\Illuminate\Http\RedirectResponse
    {

        $this->checkThreadAccess($thread);

        return Inertia::render('Threads/Edit', [
            'thread' => $thread,
            'theme' => $thread->theme
        ]);
    }

    public function update(UpdateRequest $request, Thread $thread): \Illuminate\Http\RedirectResponse
    {
        $this->checkThreadAccess($thread);

        $thread->update($request->validated());

        return redirect()->route('thread.show', ['thread' => $thread->id]);

    }

    public function destroy(Thread $thread): \Illuminate\Http\RedirectResponse
    {

        $this->checkThreadAccess($thread);

        $theme_id = $thread->theme->id;

        $thread->delete();

        return redirect()->route('theme.show', ['theme' => $theme_id]);

    }

}
