<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\DataRequest;
use App\Models\DocumentCategory;
use App\Models\IkmSurvey;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use App\Models\Official;
use App\Models\PlanningDocument;
use App\Models\RegionalIndex;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\BapperidaDataSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SecurityAuditTest extends TestCase
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

    /**
     * 1. Audit Security Headers on all public and protected routes.
     */
    public function test_all_routes_contain_required_security_headers(): void
    {
        $routes = [
            route('home'),
            route('documents.index'),
            route('news.index'),
            route('services.index'),
            route('profile'),
            route('admin.login'),
        ];

        foreach ($routes as $url) {
            $response = $this->get($url);
            $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
            $response->assertHeader('X-Content-Type-Options', 'nosniff');
            $response->assertHeader('X-XSS-Protection', '1; mode=block');
            $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        }
    }

    /**
     * 2. Audit Brute Force Lockout on Admin Login.
     */
    public function test_brute_force_attack_is_locked_out(): void
    {
        // 5 failed attempts
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post(route('admin.login.submit'), [
                'email' => 'admin@bapperida.pringsewukab.go.id',
                'password' => 'WrongPassword123!',
            ]);
            $this->assertGuest();
        }

        // 6th attempt should trigger rate limiting lockout
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@bapperida.pringsewukab.go.id',
            'password' => 'WrongPassword123!',
        ]);

        $response->assertSessionHasErrors('email');
        $errors = session('errors')->get('email');
        $this->assertStringContainsString('Terlalu banyak upaya masuk yang gagal', $errors[0]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'auth.throttled',
        ]);
    }

    /**
     * 3. Audit Anti-XSS Sanitization.
     */
    public function test_malicious_script_tags_are_stripped_from_content(): void
    {
        $category = NewsCategory::firstOrFail();
        $xssPayload = '<p>Normal paragraph</p><script>alert("XSS Attack!");</script><iframe src="malicious.com"></iframe>';

        $this->actingAs($this->admin)->post(route('admin.news.store'), [
            'category_id' => $category->id,
            'title' => 'Uji Coba Sanitasi Konten Anti XSS',
            'excerpt' => 'Ringkasan artikel',
            'content' => $xssPayload,
            'is_published' => true,
        ]);

        $article = NewsArticle::where('title', 'Uji Coba Sanitasi Konten Anti XSS')->firstOrFail();

        // Script and iframe tags must be stripped
        $this->assertStringNotContainsString('<script>', $article->content);
        $this->assertStringNotContainsString('</script>', $article->content);
        $this->assertStringNotContainsString('<iframe', $article->content);
        $this->assertStringContainsString('<p>Normal paragraph</p>', $article->content);
    }

    /**
     * 4. Audit UUID Format on All Domain Models.
     */
    public function test_all_models_strictly_use_valid_uuid_format(): void
    {
        $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

        $this->assertMatchesRegularExpression($uuidRegex, $this->admin->id);
        $this->assertMatchesRegularExpression($uuidRegex, Role::firstOrFail()->id);
        $this->assertMatchesRegularExpression($uuidRegex, DocumentCategory::firstOrFail()->id);
        $this->assertMatchesRegularExpression($uuidRegex, PlanningDocument::firstOrFail()->id);
        $this->assertMatchesRegularExpression($uuidRegex, NewsCategory::firstOrFail()->id);
        $this->assertMatchesRegularExpression($uuidRegex, NewsArticle::firstOrFail()->id);
        $this->assertMatchesRegularExpression($uuidRegex, RegionalIndex::firstOrFail()->id);
        $this->assertMatchesRegularExpression($uuidRegex, Official::firstOrFail()->id);
    }

    /**
     * 5. Audit File Upload Hardening: Reject Executable Files.
     */
    public function test_executable_and_dangerous_files_are_rejected(): void
    {
        $category = DocumentCategory::firstOrFail();
        $maliciousFile = UploadedFile::fake()->create('malicious.php', 100, 'application/x-php');

        $response = $this->actingAs($this->admin)->post(route('admin.documents.store'), [
            'category_id' => $category->id,
            'title' => 'Malicious Shell Upload Attempt',
            'year' => 2026,
            'file' => $maliciousFile,
        ]);

        $response->assertSessionHasErrors('file');
        $this->assertDatabaseMissing('planning_documents', [
            'title' => 'Malicious Shell Upload Attempt',
        ]);
    }

    /**
     * 6. Audit Public Services Rate Limiting.
     */
    public function test_public_form_throttling_prevents_spam(): void
    {
        // Submit 3 times (allowed limit)
        for ($i = 0; $i < 3; $i++) {
            $this->post(route('services.data-request'), [
                'name' => "Pemohon {$i}",
                'email' => "pemohon{$i}@test.com",
                'phone' => '081299998888',
                'purpose' => 'Akademik',
                'data_description' => 'Permintaan data uji coba.',
            ]);
        }

        // 4th attempt must be throttled
        $response = $this->post(route('services.data-request'), [
            'name' => 'Pemohon 4',
            'email' => 'pemohon4@test.com',
            'phone' => '081299998888',
            'purpose' => 'Akademik',
            'data_description' => 'Permintaan data ke-4.',
        ]);

        $response->assertSessionHasErrors('rate_limit');
    }
}
