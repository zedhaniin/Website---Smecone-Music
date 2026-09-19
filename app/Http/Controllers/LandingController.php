<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\MemberStructure;
use App\Models\Showcase;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        return view('landing', [
            'galleries' => Gallery::latest()->take(10)->get(),
            'showcases' => Showcase::latest()->take(6)->get(),
            'members' => MemberStructure::orderBy('order')->orderBy('id')->get(),
        ]);
    }

    public function about(): View
    {
        return view('about');
    }

    public function gallery(): View
    {
        return view('gallery', [
            'galleries' => Gallery::latest()->paginate(12),
        ]);
    }

    public function showcase(): View
    {
        return view('showcase', [
            'showcases' => Showcase::latest()->paginate(9),
        ]);
    }

    public function struktur(): View
    {
        return view('struktur', [
            'members' => MemberStructure::orderBy('order')->orderBy('id')->get(),
        ]);
    }
}
