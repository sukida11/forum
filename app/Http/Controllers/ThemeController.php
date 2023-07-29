<?php

namespace App\Http\Controllers;

use App\Http\Requests\Theme\StoreRequest;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ThemeController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('IndexPage', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'authUser' => auth()->user() ?? false,
        ]);
    }

    public function store(StoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        Theme::create($request->validated());
        return back();
    }

    public function show(Theme $theme)
    {
        return Inertia::render('SubThemePage', ['theme' => $theme]);
    }

}
