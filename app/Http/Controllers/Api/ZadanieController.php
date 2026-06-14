<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prax;
use App\Models\Startup;
use Illuminate\Http\Request;

class ZadanieController extends Controller
{
    private function lenFirma(Request $request): void
    {
        abort_unless($request->user()->rola === 'firma', 403, 'Len firma môže spravovať zadania.');
    }

    private function stavKey(string $stav): string
    {
        return ['Otvorené' => 'open', 'Párovanie' => 'pairing', 'V realizácii' => 'active', 'Uzavreté' => 'closed'][$stav] ?? 'open';
    }

    // jednotný tvar pre frontend (s programom)
    private function tvarPrax(Prax $p): array
    {
        return ['kod' => $p->kod, 'program' => 'B', 'nazov' => $p->zadanie, 'sektor' => $p->sektor,
            'lokalita' => $p->lokalita, 'odmena' => $p->odmena, 'popis' => $p->popis, 'stav' => $p->stav];
    }
    private function tvarStartup(Startup $s): array
    {
        return ['kod' => $s->kod, 'program' => 'A', 'nazov' => $s->nazov, 'sektor' => $s->oblast,
            'lokalita' => $s->lokalita, 'odmena' => $s->investicia, 'popis' => $s->vp, 'stav' => $s->faza];
    }

    // GET /api/zadania — vlastné zadania firmy (Program A aj B)
    public function index(Request $request)
    {
        $this->lenFirma($request);
        $uid = $request->user()->id;
        $praxe = Prax::where('user_id', $uid)->get()->map(fn ($p) => $this->tvarPrax($p));
        $startups = Startup::where('user_id', $uid)->get()->map(fn ($s) => $this->tvarStartup($s));
        return $praxe->concat($startups)->values();
    }

    // POST /api/zadania
    public function store(Request $request)
    {
        $this->lenFirma($request);

        $data = $request->validate([
            'program'  => 'required|in:A,B',
            'nazov'    => 'required|string|max:255',
            'sektor'   => 'nullable|string|max:255',
            'lokalita' => 'nullable|string|max:255',
            'odmena'   => 'nullable|string|max:255',
            'popis'    => 'nullable|string|max:2000',
            'stav'     => 'nullable|in:Otvorené,Párovanie,V realizácii,Uzavreté',
        ]);

        if ($data['program'] === 'A') {
            $kod = 'STA-' . str_pad(Startup::whereNotNull('kod')->count() + 1, 4, '0', STR_PAD_LEFT);
            $s = Startup::create([
                'user_id' => $request->user()->id, 'kod' => $kod,
                'nazov' => $data['nazov'], 'oblast' => $data['sektor'] ?? '',
                'faza' => 'Seed', 'lokalita' => $data['lokalita'] ?? '',
                'vp' => $data['popis'] ?? '', 'investicia' => $data['odmena'] ?? '',
            ]);
            return response()->json($this->tvarStartup($s), 201);
        }

        $kod = 'ZAD-' . str_pad(Prax::whereNotNull('kod')->count() + 1, 4, '0', STR_PAD_LEFT);
        $stav = $data['stav'] ?? 'Otvorené';
        $p = Prax::create([
            'user_id' => $request->user()->id, 'kod' => $kod,
            'firma' => $request->user()->meno, 'zadanie' => $data['nazov'],
            'sektor' => $data['sektor'] ?? '', 'lokalita' => $data['lokalita'] ?? '',
            'odmena' => $data['odmena'] ?? '', 'popis' => $data['popis'] ?? null,
            'stav' => $stav, 'stavKey' => $this->stavKey($stav),
        ]);
        return response()->json($this->tvarPrax($p), 201);
    }

    // PUT /api/zadania/{kod}
    public function update(Request $request, string $kod)
    {
        $this->lenFirma($request);
        $uid = $request->user()->id;

        $data = $request->validate([
            'nazov'    => 'required|string|max:255',
            'sektor'   => 'nullable|string|max:255',
            'lokalita' => 'nullable|string|max:255',
            'odmena'   => 'nullable|string|max:255',
            'popis'    => 'nullable|string|max:2000',
            'stav'     => 'nullable|in:Otvorené,Párovanie,V realizácii,Uzavreté',
        ]);

        if (str_starts_with($kod, 'STA')) {
            $s = Startup::where('kod', $kod)->firstOrFail();
            abort_unless($s->user_id === $uid, 403);
            $s->update(['nazov' => $data['nazov'], 'oblast' => $data['sektor'] ?? '',
                'lokalita' => $data['lokalita'] ?? '', 'vp' => $data['popis'] ?? '', 'investicia' => $data['odmena'] ?? '']);
            return response()->json($this->tvarStartup($s));
        }

        $p = Prax::where('kod', $kod)->firstOrFail();
        abort_unless($p->user_id === $uid, 403);
        $stav = $data['stav'] ?? $p->stav;
        $p->update(['zadanie' => $data['nazov'], 'sektor' => $data['sektor'] ?? '',
            'lokalita' => $data['lokalita'] ?? '', 'odmena' => $data['odmena'] ?? '',
            'popis' => $data['popis'] ?? null, 'stav' => $stav, 'stavKey' => $this->stavKey($stav)]);
        return response()->json($this->tvarPrax($p));
    }

    // DELETE /api/zadania/{kod}
    public function destroy(Request $request, string $kod)
    {
        $this->lenFirma($request);
        $uid = $request->user()->id;

        if (str_starts_with($kod, 'STA')) {
            $s = Startup::where('kod', $kod)->firstOrFail();
            abort_unless($s->user_id === $uid, 403);
            $s->delete();
        } else {
            $p = Prax::where('kod', $kod)->firstOrFail();
            abort_unless($p->user_id === $uid, 403);
            $p->delete();
        }
        return response()->json(['message' => 'Zadanie zmazané.']);
    }
}