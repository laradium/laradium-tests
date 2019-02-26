<?php

namespace Tests\Packages\Laradium\Integration\Translations;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportTranslationsTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCannotAccessTranslationsExport(): void
    {
        $this->loginAsGuest();

        $this->followingRedirects();

        $response = $this->get('/admin/translations/export');

        $response->assertStatus(404);
    }

    public function testExportTranslationsRouteExists(): void
    {
        $this->loginAsAdmin();

        $response = $this->get('/admin/translations/export');

        $response->assertStatus(200);
    }

    public function testExportTranslationsDownloadsExcelFile(): void
    {
        $this->loginAsAdmin();

        $response = $this->get('/admin/translations/export');

        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->assertHeader('Content-Disposition', 'attachment; filename=translations.xlsx');
        $response->assertStatus(200);
    }

    public function testCreateWithInvalidPayload(): void
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/translations');

        $response->assertStatus(422);
    }

    public function testCreateNewLanguageKey(): void
    {
        $this->loginAsAdmin();

        $this->followingRedirects();

        $response = $this->post('/admin/translations', [
            'locale' => 'en',
            'group'  => 'test',
            'key'    => 'test',
            'value'  => 'test',
        ]);

        $response->assertStatus(200);
        $response->assertLocation('/admin/translations/');
    }

    private function loginAsAdmin(): void
    {
        $this->actingAs(factory(User::class)->create([
            'is_admin' => true,
        ]));
    }

    private function loginAsGuest(): void
    {
        $this->actingAs(factory(User::class)->create([
            'is_admin' => false,
        ]));
    }
}
