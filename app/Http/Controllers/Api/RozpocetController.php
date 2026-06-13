<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rozpocet;
use Illuminate\Http\Request;

class RozpocetController extends Controller
{
    // GET /api/rozpocet — vlastný rozpočet firmy (alebo prázdny)
    public function show(Request $request)
    {
        abort_unless($request->user()->rola === 'firma', 403);
        return Rozpocet::firstOrNew(['user_id' => $request->user()->id]);
    }

    // PUT /api/rozpocet — uloženie (vytvorí alebo prepíše)
    public function update(Request $request)
    {
        abort_unless($request->user()->rola === 'firma', 403);

        $data = $request->validate([
            'schvaleny' => 'required|numeric|min:0',
            'cerpane'   => 'required|numeric|min:0',
        ]);

        $rozpocet = Rozpocet::updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return response()->json($rozpocet);
    }
}