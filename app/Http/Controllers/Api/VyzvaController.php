<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vyzva;
use App\Models\Audit;
use Illuminate\Http\Request;

class VyzvaController extends Controller
{
    public function index()
    {
        return Vyzva::orderBy('deadline')->get();
    }

    public function show(Vyzva $vyzva)
    {
        return $vyzva;
    }

    private function lenAdmin(Request $request): void
    {
        abort_unless($request->user()->rola === 'admin', 403, 'Len administrátor.');
    }

    // POST /api/vyzvy
    public function store(Request $request)
    {
        $this->lenAdmin($request);
        $data = $this->validuj($request);
        $vyzva = Vyzva::create($data);
        Audit::zapis($request->user()->id, 'Vytvorenie výzvy', $vyzva->nazov);
        return response()->json($vyzva, 201);
    }

    // PUT /api/vyzvy/{vyzva}
    public function update(Request $request, Vyzva $vyzva)
    {
        $this->lenAdmin($request);
        $vyzva->update($this->validuj($request));
        Audit::zapis($request->user()->id, 'Úprava výzvy', $vyzva->nazov);
        return response()->json($vyzva);
    }

    // DELETE /api/vyzvy/{vyzva}
    public function destroy(Request $request, Vyzva $vyzva)
    {
        $this->lenAdmin($request);
        $nazov = $vyzva->nazov;
        $vyzva->delete();
        Audit::zapis($request->user()->id, 'Zmazanie výzvy', $nazov);
        return response()->json(['message' => 'Výzva zmazaná.']);
    }

    private function validuj(Request $request): array
    {
        return $request->validate([
            'nazov'    => 'required|string|max:255',
            'program'  => 'required|in:Program A,Program B',
            'popis'    => 'nullable|string|max:2000',
            'deadline' => 'required|date',
            'stav'     => 'nullable|in:Otvorená,Uzavretá',
        ]);
    }
}