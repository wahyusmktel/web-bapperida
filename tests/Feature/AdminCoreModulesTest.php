<?php

namespace Tests\Feature;

use App\Models\DocumentCategory;
use App\Models\NewsCategory;
use App\Models\PlanningDocument;
use App\Models\RegionalIndex;
use App\Models\User;
use Database\Seeders\BapperidaDataSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCoreModulesTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            RoleAndPermissionSeeder::class,
            BapperidaDataSeeder::class,
        ]);

        $this->admin = User::where('email', 'admin@bapperida.pringsewukab.go.id')->firstOrFail();
    }

    public function test_admin_can_view_documents_list(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.documents.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Admin/Documents/Index')
            ->has('documents.data')
            ->has('categories')
        );
    }

    public function test_admin_can_create_planning_document(): void
    {
        $category = DocumentCategory::firstOrFail();

        $response = $this->actingAs($this->admin)->post(route('admin.documents.store'), [
            'category_id' => $category->id,
            'title' => 'Rencana Kerja Bapperida Tahun 2027',
            'year' => 2027,
            'document_number' => 'Kepka No. 99/2026',
            'description' => 'Dokumen uji coba otomatis rencana kerja.',
            'is_published' => true,
        ]);

        $response->assertRedirect(route('admin.documents.index'));

        $this->assertDatabaseHas('planning_documents', [
            'title' => 'Rencana Kerja Bapperida Tahun 2027',
            'year' => 2027,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'document.create',
        ]);
    }

    public function test_admin_can_toggle_document_publish_status(): void
    {
        $document = PlanningDocument::firstOrFail();
        $initialStatus = $document->is_published;

        $response = $this->actingAs($this->admin)->patch(route('admin.documents.toggle', $document));

        $response->assertRedirect();
        $this->assertEquals(! $initialStatus, $document->fresh()->is_published);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'document.toggle_publish',
        ]);
    }

    public function test_admin_can_view_news_list(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.news.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Admin/News/Index')
            ->has('articles.data')
            ->has('categories')
        );
    }

    public function test_admin_can_create_news_article(): void
    {
        $category = NewsCategory::firstOrFail();

        $response = $this->actingAs($this->admin)->post(route('admin.news.store'), [
            'category_id' => $category->id,
            'title' => 'Pringsewu Memulai Langkah Digitalisasi Data Spasial',
            'excerpt' => 'Ringkasan uji coba digitalisasi spasial.',
            'content' => '<p>Konten berita uji coba otomatis untuk validasi sanitasi XSS.</p>',
            'is_published' => true,
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseHas('news_articles', [
            'title' => 'Pringsewu Memulai Langkah Digitalisasi Data Spasial',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'news.create',
        ]);
    }

    public function test_admin_can_view_and_update_regional_indexes(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.indexes.index'));
        $response->assertOk();

        $index = RegionalIndex::firstOrFail();

        $updateResponse = $this->actingAs($this->admin)->put(route('admin.indexes.update', $index), [
            'year' => 2026,
            'score' => 65.50,
            'predicate' => 'Sangat Inovatif Unggul',
            'evaluator' => 'Kemendagri RI',
            'description' => 'Peningkatan skor capaian tahun 2026.',
        ]);

        $updateResponse->assertRedirect();

        $this->assertDatabaseHas('regional_indexes', [
            'id' => $index->id,
            'score' => 65.50,
            'predicate' => 'Sangat Inovatif Unggul',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'index.update',
        ]);
    }
}
