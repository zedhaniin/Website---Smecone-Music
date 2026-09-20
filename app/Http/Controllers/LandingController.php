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
        $allMembers = MemberStructure::orderBy('order')->orderBy('id')->get();
        $divisionDefs = MemberStructure::getDivisionDefinitions();

        $divisions = [];
        foreach ($divisionDefs as $slug => $def) {
            $members = $allMembers->filter(function ($member) use ($def) {
                return $member->division_group === $def['db_group'];
            });

            $divisions[] = array_merge($def, [
                'members' => $members->values(),
            ]);
        }

        return view('struktur', compact('divisions'));
    }

    public function strukturDetail(string $slug): View
    {
        $divisionDefs = MemberStructure::getDivisionDefinitions();

        if (! isset($divisionDefs[$slug])) {
            abort(404);
        }

        $division = $divisionDefs[$slug];
        $allMembers = MemberStructure::orderBy('order')->orderBy('id')->get();
        $members = $allMembers->filter(function ($member) use ($division) {
            return $member->division_group === $division['db_group'];
        })->values();

        return view('struktur-detail', compact('division', 'members'));
    }
}
