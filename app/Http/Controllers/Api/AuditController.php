<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    // GET /api/admin/audit — posledných 100 záznamov
    public function index(Request $request)
    {
        abort_unless($request->user()->rola === 'admin', 403);
        return Audit::with('user')->orderByDesc('id')->limit(100)->get()
            ->map(fn ($a) => [
                'akcia'  => $a->akcia,
                'objekt' => $a->objekt,
                'kto'    => optional($a->user)->cele_meno ?? '—',
                'cas'    => $a->created_at?->format('d.m.Y H:i'),
            ]);
    }
}