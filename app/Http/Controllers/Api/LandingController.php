<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Mentor,
    MentorCategory
};

class LandingController extends Controller
{
    public function index(Request $request) {
        $mentor_cats = MentorCategory::pluck('name','value')->toArray();
    }
}
