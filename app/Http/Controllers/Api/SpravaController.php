<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sprava;
use Illuminate\Http\Request;

class SpravaController extends Controller
{
    // GET /api/spravy — vlastná konverzácia (len vedúci)
    public function index(Request $request)
    {
        abort_unless($request->user()->rola === 'student', 403);
        return Sprava::where('user_id', $request->user()->id)->orderBy('id')->get();
    }

    // POST /api/spravy — odoslanie správy NTI
    public function store(Request $request)
    {
        abort_unless($request->user()->rola === 'student', 403);

        $data = $request->validate(['text' => 'required|string|max:2000']);

        $sprava = Sprava::create([
            'user_id' => $request->user()->id,
            'od'      => 'ja',
            'text'    => $data['text'],
        ]);

        return response()->json($sprava, 201);
    }
}