<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;

class PartnerController extends Controller
{
    // GET /api/partneri
    public function index()
    {
        return Partner::orderBy('nazov')->get();
    }
}