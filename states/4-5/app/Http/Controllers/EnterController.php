<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnterController extends Controller
{
    public function show()
    {
        return view('enter');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nickname' => 'required',
        ], [
            'nickname.required' => 'ニックネームを入力してください',
        ]);

        session(['nickname' => $validated['nickname']]);

        return redirect('/rooms');
    }
}
