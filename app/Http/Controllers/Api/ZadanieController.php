<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prax;
use Illuminate\Http\Request;

class ZadanieController extends Controller
{
    private function lenFirma(Request $request): void
    {
        abort_unless($request->user()->rola === 'firma', 403, 'Len firma môže spravovať zadania.');
    }

    // mapovanie čitateľného stavu na strojový kľúč (pre filtre v Program B)
    private function stavKey(string $stav): string
    {
        return [
            'Otvorené' => 'open', 'Párovanie' => 'pairing',
            'V realizácii' => 'active', 'Uzavreté' => 'closed',
        ][$stav] ?? 'open';
    }

    // tvar zadania pre frontend (dashboard firmy)
    private function tvar(Prax $p): array
    {
        return [
            'kod' => $p->kod, 'nazov' => $p->zadanie, 'sektor' => $p->sektor,
            'lokalita' => $p->lokalita, 'odmena' => $p->odmena, 'popis' => $p->popis, 'stav' => $p->stav,
        ];
    }

    // GET /api/zadania — len vlastné zadania firmy
    public function index(Request $request)
    {
        $this->lenFirma($request);
        return Prax::where('user_id', $request->user()->id)
            ->orderByDesc('id')->get()->map(fn ($p) => $this->tvar($p));
    }

    // POST /api/zadania — vytvorí zadanie v Program B
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

        $kod = 'ZAD-' . str_pad(Prax::whereNotNull('kod')->count() + 1, 4, '0', STR_PAD_LEFT);
        $stav = $data['stav'] ?? 'Otvorené';

        $p = Prax::create([
            'user_id'  => $request->user()->id,
            'kod'      => $kod,
            'firma'    => $request->user()->meno,   // názov firmy z profilu
            'zadanie'  => $data['nazov'],
            'sektor'   => $data['sektor'] ?? '',
            'lokalita' => $data['lokalita'] ?? '',
            'odmena'   => $data['odmena'] ?? '',
            'popis'    => $data['popis'] ?? null,
            'stav'     => $stav,
            'stavKey'  => $this->stavKey($stav),
        ]);

        return response()->json($this->tvar($p), 201);
    }

    // PUT /api/zadania/{kod}
    public function update(Request $request, string $kod)
    {
        $this->lenFirma($request);
        $p = Prax::where('kod', $kod)->firstOrFail();
        abort_unless($p->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'nazov'    => 'required|string|max:255',
            'sektor'   => 'nullable|string|max:255',
            'lokalita' => 'nullable|string|max:255',
            'odmena'   => 'nullable|string|max:255',
            'popis'    => 'nullable|string|max:2000',
            'stav'     => 'nullable|in:Otvorené,Párovanie,V realizácii,Uzavreté',
        ]);

        $stav = $data['stav'] ?? $p->stav;
        $p->update([
            'zadanie'  => $data['nazov'],
            'sektor'   => $data['sektor'] ?? '',
            'lokalita' => $data['lokalita'] ?? '',
            'odmena'   => $data['odmena'] ?? '',
            'popis'    => $data['popis'] ?? null,
            'stav'     => $stav,
            'stavKey'  => $this->stavKey($stav),
        ]);

        return response()->json($this->tvar($p));
    }

    // DELETE /api/zadania/{kod}
    public function destroy(Request $request, string $kod)
    {
        $this->lenFirma($request);
        $p = Prax::where('kod', $kod)->firstOrFail();
        abort_unless($p->user_id === $request->user()->id, 403);

        $p->delete();
        return response()->json(['message' => 'Zadanie zmazané.']);
    }
}