<?php

namespace App\Http\Controllers;

use App\Http\Requests\Theme\StoreRequest;
use App\Http\Requests\Theme\UpdateRequest;
use App\Models\Theme;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mockery\Exception;

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

    public function show(Theme $theme): \Inertia\Response
    {

        return Inertia::render('SubThemePage', [
            'themes' => Theme::where('parent_id', $theme->id)->latest()->get(), // thems into showed theme
            'parent_theme' => $theme, // showed them
            'parent_themes' => $theme->getParentThemes(),// theme who stay upper than showed theme
            'threads' => $theme->threads()->latest()->get()
        ]);
    }

    public function edit(Theme $theme): \Inertia\Response
    {
        return Inertia::render('Theme/Edit', [
            'theme' => $theme
        ]);
    }

    public function update(UpdateRequest $request, Theme $theme): \Illuminate\Http\RedirectResponse
    {
        $theme->update($request->validated());

        return Redirect::route('main.index');
    }

    public function destroy(Theme $theme): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $children = $theme->getChildrenThemes($theme->id)->each(function ($item) {
                $item->delete();
            });


            $theme->delete();



            DB::commit();
        } catch (\Exception $e)
        {
            DB::rollBack();
        }

        return \redirect()->back();

    }

}
