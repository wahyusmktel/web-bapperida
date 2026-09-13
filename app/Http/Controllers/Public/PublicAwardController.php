<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Award;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicAwardController extends Controller
{
    /**
     * Display the awards and honors gallery.
     */
    public function index(Request $request): Response
    {
        $query = Award::where('is_published', true)
            ->orderByDesc('year')
            ->orderByDesc('award_date')
            ->orderBy('order');

        if ($request->filled('year')) {
            $query->where('year', (int) $request->input('year'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('organizer', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $awards = $query->paginate(9)->withQueryString()->through(function ($awd) {
            return [
                'id' => $awd->id,
                'name' => $awd->name,
                'slug' => $awd->slug,
                'year' => $awd->year,
                'award_date' => $awd->award_date?->translatedFormat('d F Y') ?? '-',
                'category' => $awd->category,
                'organizer' => $awd->organizer,
                'description' => $awd->description,
                'image_path' => $awd->image_path,
            ];
        });

        $years = Award::where('is_published', true)
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $categories = Award::where('is_published', true)
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return Inertia::render('Public/Awards/Index', [
            'awards' => $awards,
            'years' => $years,
            'categories' => $categories,
            'filters' => $request->only(['year', 'category', 'search']),
        ]);
    }
}
