<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zadanie;
use Illuminate\Http\Request;

class ZadanieController extends Controller
{
    // overenie roly — len firma smie spravovať zadania
    private function lenFirma(Request $request): void
    {
        abort_unless($request->user()->rola === 'firma', 403, 'Len firma môže spravovať zadania.');
    }

    // GET /api/zadania — len vlastné zadania prihlásenej firmy
    public function index(Request $request)
    {
        $this->lenFirma($request);
        return $request->user()->id
            ? Zadanie::where('user_id', $request->user()->id)->orderByDesc('id')->get()
            : [];
    }

    // POST /api/zadania
    public function store(Request $request)
    {
        $this->lenFirma($request);

        $data = $request->validate([
            'nazov'    => 'required|string|max:255',
            'sektor'   => 'nullable|string|max:255',
            'lokalita' => 'nullable|string|max:255',
            'odmena'   => 'nullable|string|max:255',
            'popis'    => 'nullable|string|max:2000',
            'stav'     => 'nullable|in:Otvorené,Párovanie,V realizácii,Uzavreté',
        ]);

        // vygeneruj unikátny kód ZAD-XXXX
        $kod = 'ZAD-' . str_pad(Zadanie::count() + 1, 4, '0', STR_PAD_LEFT);

        $zadanie = Zadanie::create([
            'kod'      => $kod,
            'user_id'  => $request->user()->id,
            'nazov'    => $data['nazov'],
            'sektor'   => $data['sektor'] ?? '',
            'lokalita' => $data['lokalita'] ?? '',
            'odmena'   => $data['odmena'] ?? '',
            'popis'    => $data['popis'] ?? null,
            'stav'     => $data['stav'] ?? 'Otvorené',
        ]);

        return response()->json($zadanie, 201);
    }

    // PUT /api/zadania/{zadanie}
    public function update(Request $request, Zadanie $zadanie)
    {
        $this->lenFirma($request);
        // vlastnícka kontrola — nemôžem upraviť cudzie zadanie
        abort_unless($zadanie->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'nazov'    => 'required|string|max:255',
            'sektor'   => 'nullable|string|max:255',
            'lokalita' => 'nullable|string|max:255',
            'odmena'   => 'nullable|string|max:255',
            'popis'    => 'nullable|string|max:2000',
            'stav'     => 'nullable|in:Otvorené,Párovanie,V realizácii,Uzavreté',
        ]);

        $zadanie->update($data);
        return response()->json($zadanie);
    }

    // DELETE /api/zadania/{zadanie}
    public function destroy(Request $request, Zadanie $zadanie)
    {
        $this->lenFirma($request);
        abort_unless($zadanie->user_id === $request->user()->id, 403);

        $zadanie->delete();
        return response()->json(['message' => 'Zadanie zmazané.']);
    }
}