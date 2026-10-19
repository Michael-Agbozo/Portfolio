<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class StaleAssetRedirectTest extends TestCase
{
    private string $public;

    protected function setUp(): void
    {
        parent::setUp();

        $this->public = storage_path('framework/testing/public-'.uniqid());
        File::ensureDirectoryExists($this->public.'/build/assets');
        File::put($this->public.'/build/manifest.json', json_encode([
            'resources/css/emerald.css' => ['file' => 'assets/emerald-KkKYpXGz.css', 'src' => 'resources/css/emerald.css'],
            'resources/js/app.js' => ['file' => 'assets/app-BvRk9kiK.js', 'src' => 'resources/js/app.js'],
        ]));
        $this->app->usePublicPath($this->public);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->public);
        parent::tearDown();
    }

    public function test_old_stylesheet_name_redirects_to_the_current_one(): void
    {
        $this->get('/build/assets/emerald--AMaFjYA.css')
            ->assertRedirect(asset('build/assets/emerald-KkKYpXGz.css'))
            ->assertHeader('Cache-Control', 'no-store, private');
    }

    public function test_old_script_name_redirects_to_the_current_one(): void
    {
        $this->get('/build/assets/app-OldHash1.js')
            ->assertRedirect(asset('build/assets/app-BvRk9kiK.js'));
    }

    public function test_unknown_or_odd_names_are_not_found(): void
    {
        $this->get('/build/assets/nothing-like-it.css')->assertNotFound();
        $this->get('/build/assets/dashboard-AbCdEfGh.css')->assertNotFound();
        $this->get('/build/assets/emerald.css')->assertNotFound();
    }
}
