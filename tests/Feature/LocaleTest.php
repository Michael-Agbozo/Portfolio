<?php

namespace Tests\Feature;

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    use RefreshDatabase;

    private function translation(string $locale, string $english): string
    {
        $file = lang_path($locale.'.json');
        $strings = is_file($file) ? json_decode(file_get_contents($file), true) : [];

        return $strings[$english] ?? $english;
    }

    public function test_english_is_the_default(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertHeader('Content-Language', 'en')
            ->assertSee('View my work');
    }

    public function test_browser_language_is_detected(): void
    {
        $this->withHeader('Accept-Language', 'fr-BE,fr;q=0.9,en;q=0.5')
            ->get('/')
            ->assertOk()
            ->assertSee('<html lang="fr">', false)
            ->assertHeader('Content-Language', 'fr')
            ->assertSee($this->translation('fr', 'View my work'));
    }

    public function test_unsupported_browser_language_falls_back_to_english(): void
    {
        $this->withHeader('Accept-Language', 'ja-JP,ja;q=0.9')
            ->get('/')
            ->assertSee('<html lang="en">', false);
    }

    public function test_a_chosen_language_beats_the_browser_language(): void
    {
        $this->withHeader('Accept-Language', 'fr')
            ->withCookie(SetLocale::COOKIE, 'de')
            ->get('/about')
            ->assertSee('<html lang="de">', false);
    }

    public function test_the_language_menu_remembers_the_choice(): void
    {
        $this->get('/language/nl')
            ->assertRedirect()
            ->assertCookie(SetLocale::COOKIE, 'nl');

        $this->get('/language/xx')->assertNotFound();
    }

    public function test_every_language_file_has_every_phrase(): void
    {
        $english = json_decode(file_get_contents(lang_path('en.json')), true);

        foreach (array_keys(config('app.supported_locales')) as $locale) {
            if ($locale === 'en') {
                continue;
            }

            $translated = json_decode(file_get_contents(lang_path($locale.'.json')), true);
            $this->assertSame([], array_values(array_diff(array_keys($english), array_keys($translated))), "{$locale}.json is missing phrases");

            foreach ($english as $key => $_) {
                foreach ([':count', ':project', ':number'] as $placeholder) {
                    if (str_contains($key, $placeholder)) {
                        $this->assertStringContainsString($placeholder, $translated[$key], "{$locale}: {$key}");
                    }
                }
            }
        }
    }

    public function test_error_pages_follow_the_visitor_language(): void
    {
        $this->withHeader('Accept-Language', 'es')
            ->get('/this-page-does-not-exist')
            ->assertNotFound()
            ->assertSee('<html lang="es">', false)
            ->assertSee($this->translation('es', 'This page slipped out of frame.'));
    }
}
