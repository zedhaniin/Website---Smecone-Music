<?php

namespace App\Http\Controllers;

use App\Models\Division;
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
            'galleries' => Gallery::withCount('photos')->latest()->paginate(9),
        ]);
    }

    public function galleryDetail(Gallery $gallery): View
    {
        $gallery->load('photos');

        $otherGalleries = Gallery::where('id', '!=', $gallery->id)
            ->withCount('photos')
            ->latest()
            ->take(3)
            ->get();

        return view('gallery-detail', [
            'gallery' => $gallery,
            'otherGalleries' => $otherGalleries,
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
        $divisions = Division::with('members')->orderBy('order')->orderBy('id')->get();

        foreach ($divisions as $division) {
            if ($division->members->isEmpty()) {
                $matchPattern = match ($division->slug) {
                    'pengurus-inti' => ['Ketua', 'Wakil', 'Sekretaris 1', 'Sekretaris 2', 'Bendahara 1', 'Bendahara 2'],
                    'humas' => '%Humas%',
                    'alat-musik' => '%Alat Musik%',
                    'vocal' => '%Vocal%',
                    'kegiatan' => '%Kegiatan%',
                    'pdd' => '%PDD%',
                    'perkap' => '%Perkap%',
                    'wirausaha' => '%Wirausaha%',
                    default => null,
                };

                $fallbackMembers = MemberStructure::where('division_id', $division->id);
                if (is_array($matchPattern)) {
                    $fallbackMembers->orWhereIn('position', $matchPattern);
                } elseif (is_string($matchPattern)) {
                    $fallbackMembers->orWhere('position', 'like', $matchPattern);
                }

                $division->setRelation('members', $fallbackMembers->orderBy('order')->orderBy('id')->get());
            }
        }

        return view('struktur', compact('divisions'));
    }

    public function strukturDetail(string $slug): View
    {
        $division = Division::where('slug', $slug)->firstOrFail();
        
        $matchPattern = match ($division->slug) {
            'pengurus-inti' => ['Ketua', 'Wakil', 'Sekretaris 1', 'Sekretaris 2', 'Bendahara 1', 'Bendahara 2'],
            'humas' => '%Humas%',
            'alat-musik' => '%Alat Musik%',
            'vocal' => '%Vocal%',
            'kegiatan' => '%Kegiatan%',
            'pdd' => '%PDD%',
            'perkap' => '%Perkap%',
            'wirausaha' => '%Wirausaha%',
            default => null,
        };

        $membersQuery = MemberStructure::where('division_id', $division->id);
        if (is_array($matchPattern)) {
            $membersQuery->orWhereIn('position', $matchPattern);
        } elseif (is_string($matchPattern)) {
            $membersQuery->orWhere('position', 'like', $matchPattern);
        }

        $members = $membersQuery->orderBy('order')->orderBy('id')->get();

        return view('struktur-detail', compact('division', 'members'));
    }
}
