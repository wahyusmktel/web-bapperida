<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\DocumentCategory;
use App\Models\PlanningDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DocumentController extends Controller
{
    /**
     * Display a listing of planning documents.
     */
    public function index(Request $request): Response
    {
        $query = PlanningDocument::with('category:id,name,slug')
            ->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('year')) {
            $query->where('year', $request->input('year'));
        }

        $documents = $query->paginate(10)->withQueryString()->through(function ($doc) {
            return [
                'id' => $doc->id,
                'title' => $doc->title,
                'slug' => $doc->slug,
                'category_name' => $doc->category?->name ?? 'Umum',
                'year' => $doc->year,
                'document_number' => $doc->document_number ?? '-',
                'file_name' => $doc->file_name,
                'file_size' => $doc->formattedFileSize(),
                'downloads_count' => $doc->downloads_count,
                'is_published' => $doc->is_published,
                'published_at' => $doc->published_at?->translatedFormat('d M Y') ?? '-',
            ];
        });

        $categories = DocumentCategory::select('id', 'name', 'slug')->get();
        $years = PlanningDocument::select('year')->distinct()->orderByDesc('year')->pluck('year');

        return Inertia::render('Admin/Documents/Index', [
            'documents' => $documents,
            'categories' => $categories,
            'years' => $years,
            'filters' => $request->only(['search', 'category_id', 'year']),
        ]);
    }

    /**
     * Store a newly created planning document in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:document_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:2000', 'max:2099'],
            'document_number' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:25600'], // max 25MB PDF
            'is_published' => ['boolean'],
        ]);

        $filePath = null;
        $fileName = null;
        $fileSize = null;
        $fileMime = null;

        if ($request->hasFile('file')) {
            $uploaded = $request->file('file');
            $fileName = $uploaded->getClientOriginalName();
            $fileSize = $uploaded->getSize();
            $fileMime = $uploaded->getMimeType();
            $filePath = $uploaded->store('documents/planning', 'public');
        }

        $document = PlanningDocument::create([
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::lower(Str::random(6)),
            'year' => $validated['year'],
            'document_number' => $validated['document_number'] ?? null,
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'file_mime' => $fileMime,
            'is_published' => $request->boolean('is_published', true),
            'published_at' => now(),
        ]);

        Cache::forget('bapperida:stats:overview');
        Cache::forget('bapperida:public:home');

        ActivityLog::record(
            action: 'document.create',
            description: "Mengunggah dokumen perencanaan: {$document->title}",
            properties: ['document_id' => $document->id, 'title' => $document->title]
        );

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen perencanaan berhasil ditambahkan.');
    }

    /**
     * Update the specified planning document.
     */
    public function update(Request $request, PlanningDocument $document): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:document_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:2000', 'max:2099'],
            'document_number' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:25600'],
            'is_published' => ['boolean'],
        ]);

        if ($request->hasFile('file')) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $uploaded = $request->file('file');
            $document->file_name = $uploaded->getClientOriginalName();
            $document->file_size = $uploaded->getSize();
            $document->file_mime = $uploaded->getMimeType();
            $document->file_path = $uploaded->store('documents/planning', 'public');
        }

        $document->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'year' => $validated['year'],
            'document_number' => $validated['document_number'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_published' => $request->boolean('is_published'),
        ]);

        Cache::forget('bapperida:stats:overview');
        Cache::forget('bapperida:public:home');

        ActivityLog::record(
            action: 'document.update',
            description: "Memperbarui dokumen perencanaan: {$document->title}",
            properties: ['document_id' => $document->id]
        );

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen perencanaan berhasil diperbarui.');
    }

    /**
     * Toggle the publication status of a document.
     */
    public function togglePublish(PlanningDocument $document): RedirectResponse
    {
        $document->is_published = ! $document->is_published;
        $document->save();

        Cache::forget('bapperida:stats:overview');
        Cache::forget('bapperida:public:home');

        ActivityLog::record(
            action: 'document.toggle_publish',
            description: "Mengubah status publikasi dokumen {$document->title} menjadi ".($document->is_published ? 'Publik' : 'Draft'),
            properties: ['document_id' => $document->id, 'is_published' => $document->is_published]
        );

        return back()->with('success', 'Status publikasi berhasil diperbarui.');
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(PlanningDocument $document): RedirectResponse
    {
        $title = $document->title;
        $id = $document->id;

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        Cache::forget('bapperida:stats:overview');
        Cache::forget('bapperida:public:home');

        ActivityLog::record(
            action: 'document.delete',
            description: "Menghapus dokumen perencanaan: {$title}",
            properties: ['document_id' => $id]
        );

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
