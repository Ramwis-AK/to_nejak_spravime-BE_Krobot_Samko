<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Novinka;
use App\Models\Audit;
use Illuminate\Http\Request;

class NovinkaController extends Controller
{
    public function index()
    {
        return Novinka::orderBy('datum', 'desc')->get();
    }

    public function show(Novinka $novinka)
    {
        return $novinka;
    }

    private function lenAdmin(Request $request): void
    {
        abort_unless($request->user()->rola === 'admin', 403, 'Len administrátor.');
    }

    private function validuj(Request $request): array
    {
        return $request->validate([
            'titul'     => 'required|string|max:255',
            'datum'     => 'required|date',
            'perex'     => 'required|string|max:500',
            'kategoria' => 'required|string|max:100',
            'obsah'     => 'nullable|string|max:5000',
        ]);
    }

    // POST /api/novinky
    public function store(Request $request)
    {
        $this->lenAdmin($request);
        $n = Novinka::create($this->validuj($request));
        Audit::zapis($request->user()->id, 'Vytvorenie novinky', $n->titul);
        return response()->json($n, 201);
    }

    // PUT /api/novinky/{novinka}
    public function update(Request $request, Novinka $novinka)
    {
        $this->lenAdmin($request);
        $novinka->update($this->validuj($request));
        Audit::zapis($request->user()->id, 'Úprava novinky', $novinka->titul);
        return response()->json($novinka);
    }

    // DELETE /api/novinky/{novinka}
    public function destroy(Request $request, Novinka $novinka)
    {
        $this->lenAdmin($request);
        $titul = $novinka->titul;
        $novinka->delete();
        Audit::zapis($request->user()->id, 'Zmazanie novinky', $titul);
        return response()->json(['message' => 'Novinka zmazaná.']);
    }
}