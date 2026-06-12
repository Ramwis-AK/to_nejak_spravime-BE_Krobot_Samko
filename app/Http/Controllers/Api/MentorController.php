<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mentor;

class MentorController extends Controller
{
    // GET /api/mentori
    public function index()
    {
        return Mentor::orderBy('meno')->get();
    }
}