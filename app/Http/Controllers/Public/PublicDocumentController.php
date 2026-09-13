<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use App\Models\PlanningDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicDocumentController extends Controller
{
    /**
     * Display public repository of planning documents.
     */
    public function index(Request $request): Response
    {
        $query = PlanningDocument::with('category:id,name,slug')
            ->where('is_published', true)
            ->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->input('year'));
        }

        $documents = $query->paginate(9)->withQueryString()->through(function ($doc) {
            return [
                'id' => $doc->id,
                'title' => $doc->title,
                'slug' => $doc->slug,
                'category_name' => $doc->category?->name ?? 'Perencanaan',
                'category_slug' => $doc->category?->slug ?? 'perencanaan',
                'year' => $doc->year,
                'document_number' => $doc->document_number ?? '-',
                'description' => $doc->description,
                'file_name' => $doc->file_name,
                'file_size' => $doc->formattedFileSize(),
                'downloads_count' => $doc->downloads_count,
                'published_at' => $doc->published_at?->translatedFormat('d F Y') ?? '-',
            ];
        });

        $categories = DocumentCategory::select('id', 'name', 'slug')->get();
        $years = PlanningDocument::where('is_published', true)->select('year')->distinct()->orderByDesc('year')->pluck('year');

        return Inertia::render('Public/Documents', [
            'documents' => $documents,
            'categories' => $categories,
            'years' => $years,
            'filters' => $request->only(['search', 'category', 'year']),
        ]);
    }

    /**
     * Increment download counter and safely download document.
     */
    public function download(string $slug)
    {
        $document = PlanningDocument::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment counter
        $document->increment('downloads_count');

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            return response()->download(
                Storage::disk('public')->path($document->file_path),
                $document->file_name ?? "{$document->slug}.pdf"
            );
        }

        return redirect()->back()->with('error', 'Berkas dokumen belum tersedia untuk diunduh langsung.');
    }
}
