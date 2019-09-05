<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntroController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();

        $intros = $user->intros;

        $intros[] = $request->intro;

        $user->intros = $intros;

        $user->save();
    }
}
