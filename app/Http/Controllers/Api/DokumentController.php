<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dokument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumentController extends Controller
{
    // GET /api/dokumenty — len vlastné dokumenty
    public function index(Request $request)
    {
        return Dokument::where('user_id', $request->user()->id)->orderByDesc('id')->get();
    }

    // POST /api/dokumenty — nahratie súboru
    public function store(Request $request)
    {
        // Bezpečnostná validácia: povolené typy + max veľkosť 5 MB
        $request->validate([
            'subor' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $file = $request->file('subor');
        // uloží sa do storage/app/dokumenty (neverejné — prístup len cez controller)
        $cesta = $file->store('dokumenty');

        $doc = Dokument::create([
            'user_id' => $request->user()->id,
            'nazov'   => $file->getClientOriginalName(),
            'cesta'   => $cesta,
            'mime'    => $file->getClientMimeType(),
            'velkost' => $file->getSize(),
        ]);

        return response()->json($doc, 201);
    }

    // GET /api/dokumenty/{dokument}/stiahnut — stiahnutie (len vlastník)
    public function download(Request $request, Dokument $dokument)
    {
        abort_unless($dokument->user_id === $request->user()->id, 403);
        abort_unless(Storage::exists($dokument->cesta), 404);

        return Storage::download($dokument->cesta, $dokument->nazov);
    }

    // DELETE /api/dokumenty/{dokument} — zmazanie (len vlastník)
    public function destroy(Request $request, Dokument $dokument)
    {
        abort_unless($dokument->user_id === $request->user()->id, 403);

        Storage::delete($dokument->cesta); // zmaž aj fyzický súbor
        $dokument->delete();

        return response()->json(['message' => 'Dokument zmazaný.']);
    }

        public function firmaStiahnut(Request $request, Dokument $dokument)
    {
        abort_unless($request->user()->rola === 'firma', 403);

        $opravneny = \App\Models\Prihlaska::where('user_id', $dokument->user_id)
            ->whereHas('prax', fn ($q) => $q->where('user_id', $request->user()->id))
            ->exists();

        abort_unless($opravneny, 403);
        abort_unless(Storage::exists($dokument->cesta), 404);

        return Storage::download($dokument->cesta, $dokument->nazov);
    }
}