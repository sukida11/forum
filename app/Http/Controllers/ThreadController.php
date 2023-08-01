<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Requests\Thread\StoreRequest;
use Inertia\Inertia;
use JetBrains\PhpStorm\NoReturn;

class ThreadController extends Controller
{
    public function index()
    {

    }

    public function show(Thread $thread)
    {

        return Inertia::render('Threads/Show', [
            'thread' => $thread,
            'theme' => $thread->theme
        ]);

    }

    public function store(StoreRequest $request)
    {
        Thread::create($request->validated());
        return redirect()->back();
    }
}
