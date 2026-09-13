<?php

namespace Tests\Feature;

use App\Models\NewsArticle;
use App\Models\PlanningDocument;
use Database\Seeders\BapperidaDataSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            RoleAndPermissionSeeder::class,
            BapperidaDataSeeder::class,
        ]);
    }

    public function test_homepage_renders_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Public/Home')
            ->has('featuredDocuments')
            ->has('latestNews')
            ->has('indexes')
        );
    }

    public function test_public_documents_page_renders_successfully(): void
    {
        $response = $this->get(route('documents.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Public/Documents')
            ->has('documents.data')
            ->has('categories')
            ->has('years')
        );
    }

    public function test_document_download_increments_downloads_count(): void
    {
        $document = PlanningDocument::firstOrFail();
        $initialDownloads = $document->downloads_count;

        $response = $this->get(route('documents.download', $document->slug));

        $this->assertEquals($initialDownloads + 1, $document->fresh()->downloads_count);
    }

    public function test_public_news_index_renders_successfully(): void
    {
        $response = $this->get(route('news.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Public/News/Index')
            ->has('articles.data')
            ->has('categories')
        );
    }

    public function test_public_news_subpages_render_successfully(): void
    {
        $this->get(route('news.umum'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/News/Umum')->has('articles.data')->has('meta'));

        $this->get(route('news.ppe'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/News/Ppe')->has('articles.data')->has('meta'));

        $this->get(route('news.ppm'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/News/Ppm')->has('articles.data')->has('meta'));

        $this->get(route('news.psda'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/News/Psda')->has('articles.data')->has('meta'));

        $this->get(route('news.ipw'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/News/Ipw')->has('articles.data')->has('meta'));

        $this->get(route('news.rida'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/News/Rida')->has('articles.data')->has('meta'));
    }

    public function test_public_news_show_increments_views_count(): void
    {
        $article = NewsArticle::firstOrFail();
        $initialViews = $article->views_count;

        $response = $this->get(route('news.show', $article->slug));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Public/News/Show')
            ->has('article')
            ->has('relatedArticles')
        );

        $this->assertEquals($initialViews + 1, $article->fresh()->views_count);
    }

    public function test_public_profile_page_renders_successfully(): void
    {
        $response = $this->get(route('profile'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Public/Profile')
            ->has('officials')
        );
    }

    public function test_public_profile_subpages_render_successfully(): void
    {
        $this->get(route('profile.visi-misi'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/Profile/VisiMisi'));

        $this->get(route('profile.struktur-organisasi'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/Profile/StrukturOrganisasi')->has('officials'));

        $this->get(route('profile.tupoksi'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/Profile/Tupoksi'));

        $this->get(route('profile.pejabat'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/Profile/Pejabat')->has('officials'));

        $this->get(route('profile.statistik-pegawai'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/Profile/StatistikPegawai'));

        $this->get(route('profile.kontak'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Public/Profile/Kontak'));
    }

    public function test_public_documents_subpages_render_successfully(): void
    {
        $this->get(route('documents.perencanaan'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Public/Documents/Perencanaan')
                ->has('documents.data')
                ->has('years')
                ->has('meta')
            );

        $this->get(route('documents.kajian'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Public/Documents/Kajian')
                ->has('documents.data')
                ->has('years')
                ->has('meta')
            );

        $this->get(route('documents.analisis'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Public/Documents/Analisis')
                ->has('documents.data')
                ->has('years')
                ->has('meta')
            );
    }

    public function test_public_services_page_renders_successfully(): void
    {
        $response = $this->get(route('services.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Public/Services')
            ->has('ikmStats')
        );
    }

    public function test_citizen_can_submit_data_request(): void
    {
        $response = $this->post(route('services.data-request'), [
            'name' => 'Warga Pringsewu Test',
            'email' => 'warga@gmail.com',
            'phone' => '081234567890',
            'institution' => 'Universitas Lampung',
            'purpose' => 'Penelitian Skripsi',
            'data_description' => 'Memohon data spasial tutupan lahan Pringsewu 2024-2025.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('data_requests', [
            'email' => 'warga@gmail.com',
            'name' => 'Warga Pringsewu Test',
        ]);
    }

    public function test_citizen_can_submit_ikm_survey(): void
    {
        $response = $this->post(route('services.survey'), [
            'respondent_type' => 'Masyarakat Umum',
            'rating_service_ease' => 5,
            'rating_speed' => 5,
            'rating_transparency' => 5,
            'rating_satisfaction' => 5,
            'feedback' => 'Pelayanan BAPPERIDA sangat memuaskan dan transparan.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('ikm_surveys', [
            'respondent_type' => 'Masyarakat Umum',
            'rating_satisfaction' => 5,
        ]);
    }

    public function test_public_awards_page_renders_successfully(): void
    {
        $response = $this->get(route('awards.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Public/Awards/Index')
            ->has('awards.data')
            ->has('years')
            ->has('categories')
            ->has('filters')
        );
    }

    public function test_public_reports_pages_render_successfully(): void
    {
        $this->get(route('reports.iid'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Public/Reports/Iid')
                ->has('reports.data')
                ->has('years')
                ->has('meta')
            );

        $this->get(route('reports.idsd'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Public/Reports/Idsd')
                ->has('reports.data')
                ->has('years')
                ->has('meta')
            );

        $this->get(route('reports.ipkd'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Public/Reports/Ipkd')
                ->has('reports.data')
                ->has('years')
                ->has('meta')
            );

        $this->get(route('reports.lakip'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Public/Reports/Lakip')
                ->has('reports.data')
                ->has('years')
                ->has('meta')
            );
    }

    public function test_public_sitemap_renders_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=utf-8');
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $response->getContent());
        $this->assertStringContainsString('<loc>', $response->getContent());
    }
}
