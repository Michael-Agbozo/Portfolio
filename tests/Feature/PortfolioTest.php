<?php

namespace Tests\Feature;

use App\Mail\ContactMessageConfirmation;
use App\Mail\ContactMessageReceived;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    public function test_homepage_includes_core_seo_metadata(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('<link rel="canonical" href="http://localhost"/>', false);
        $response->assertSee('<meta property="og:title" content="Michael Agbozo', false);
        $response->assertSee('"@type": "Person"', false);
    }

    public function test_about_page_includes_experience_seo_and_project_proof(): void
    {
        $project = Project::create([
            'num' => '01',
            'category' => 'development',
            'title' => 'Remote Dashboard Project',
            'slug' => 'remote-dashboard-project',
            'meta' => 'A Laravel dashboard project for remote operations.',
            'tags' => ['Laravel', 'Dashboard'],
            'images' => [],
            'active' => true,
        ]);

        $hiddenProject = Project::create([
            'num' => '02',
            'category' => 'design',
            'title' => 'Hidden Brand Project',
            'slug' => 'hidden-brand-project',
            'meta' => 'This should not appear publicly.',
            'tags' => [],
            'images' => [],
            'active' => false,
        ]);

        $response = $this->get('/about');

        $response->assertOk();
        $response->assertViewIs('about');
        $response->assertSee('<title>About Michael Agbozo | Remote Web Developer, Designer and IT Systems Support</title>', false);
        $response->assertSee('Ghana-based IT Systems and Web Developer offering remote Laravel development', false);
        $response->assertSee('"ProfilePage"', false);
        $response->assertSee('"@type": "BreadcrumbList"', false);
        $response->assertSee('Four Corners Community Services');
        $response->assertSee('La Necar Logistics');
        $response->assertSee('Remote Dashboard Project');
        $response->assertSee(route('project.show', $project), false);
        $response->assertDontSee($hiddenProject->title);
    }

    public function test_project_page_includes_project_specific_seo_metadata(): void
    {
        $project = Project::create([
            'num' => '01',
            'category' => 'development',
            'title' => 'SEO Project',
            'slug' => 'seo-project',
            'meta' => 'A search friendly Laravel portfolio project.',
            'tags' => ['Laravel', 'SEO'],
            'images' => [],
            'active' => true,
        ]);

        $response = $this->get(route('project.show', $project));

        $response->assertOk();
        $response->assertSee('<meta name="description" content="A search friendly Laravel portfolio project."', false);
        $response->assertSee('<link rel="canonical" href="http://localhost/projects/seo-project"/>', false);
        $response->assertSee('"@type": "CreativeWork"', false);
        $response->assertSee('"@type": "BreadcrumbList"', false);
    }

    public function test_project_page_shows_case_study_details_when_available(): void
    {
        $project = Project::create([
            'num' => '03',
            'category' => 'development',
            'title' => 'Detailed Case Study',
            'slug' => 'detailed-case-study',
            'meta' => 'A project with a complete case study.',
            'body' => 'A concise overview.',
            'tags' => ['Laravel'],
            'services' => ['Web Design', 'Laravel'],
            'tech_stack' => ['Laravel', 'Tailwind'],
            'client_name' => 'Poetik Koncept',
            'project_year' => '2026',
            'challenge' => 'The old site needed a better structure.',
            'solution' => 'Built a cleaner showcase experience.',
            'results' => 'The project story is easier to understand.',
            'testimonial' => 'The work feels clear and professional.',
            'before_image' => '/storage/projects/before.jpg',
            'after_image' => '/storage/projects/after.jpg',
            'images' => [],
            'active' => true,
        ]);

        $response = $this->get(route('project.show', $project));

        $response->assertOk();
        $response->assertSee('Client');
        $response->assertSee('Poetik Koncept');
        $response->assertSee('Services');
        $response->assertSee('Web Design, Laravel');
        $response->assertSee('Tech Stack');
        $response->assertSee('Laravel, Tailwind');
        $response->assertSee('The Challenge');
        $response->assertSee('The Solution');
        $response->assertSee('Results / Outcome');
        $response->assertSee('Before / After');
        $response->assertSee('The work feels clear and professional.');
    }

    public function test_service_page_includes_service_specific_seo_metadata(): void
    {
        $response = $this->get('/services/laravel-development-ghana');

        $response->assertOk();
        $response->assertViewIs('service');
        $response->assertSee('<title>Remote Laravel Developer in Ghana | Michael Agbozo</title>', false);
        $response->assertSee('<meta name="description" content="Hire Michael Agbozo for Laravel development in Ghana and remotely', false);
        $response->assertSee('<link rel="canonical" href="http://localhost/services/laravel-development-ghana"/>', false);
        $response->assertSee('"@type": "Service"', false);
        $response->assertSee('"@type": "FAQPage"', false);
        $response->assertSee('Laravel developer Ghana');
        $response->assertSee('remote Laravel developer');
    }

    public function test_unknown_service_page_returns_not_found(): void
    {
        $this->get('/services/not-a-real-service')->assertNotFound();
    }

    public function test_sitemap_lists_active_public_projects_only(): void
    {
        Project::create([
            'num' => '01',
            'category' => 'development',
            'title' => 'Public Project',
            'slug' => 'public-project',
            'meta' => 'Visible project',
            'tags' => [],
            'images' => [],
            'active' => true,
        ]);

        Project::create([
            'num' => '02',
            'category' => 'development',
            'title' => 'Hidden Project',
            'slug' => 'hidden-project',
            'meta' => 'Hidden project',
            'tags' => [],
            'images' => [],
            'active' => false,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/xml');
        $response->assertSee('<loc>http://localhost</loc>', false);
        $response->assertSee('<loc>http://localhost/about</loc>', false);
        $response->assertSee('<loc>http://localhost/services/laravel-development-ghana</loc>', false);
        $response->assertSee('<loc>http://localhost/services/wordpress-website-design-ghana</loc>', false);
        $response->assertSee('<loc>http://localhost/services/brand-identity-design-ghana</loc>', false);
        $response->assertSee('<loc>http://localhost/services/print-cutline-artwork-ghana</loc>', false);
        $response->assertSee('<loc>http://localhost/services/it-systems-support-ghana</loc>', false);
        $response->assertSee('<loc>http://localhost/projects/public-project</loc>', false);
        $response->assertDontSee('hidden-project');
    }

    public function test_robots_txt_points_crawlers_to_the_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertSee('Disallow: /dashboard/');
        $response->assertSee('Sitemap: https://michaelagbozo.com/sitemap.xml');
    }

    public function test_not_found_page_matches_the_portfolio_theme(): void
    {
        $response = $this->get('/missing-page');

        $response->assertNotFound();
        $response->assertSee('This page slipped out of frame.');
        $response->assertSee('Michael Agbozo<span class="text-orange">.</span>', false);
        $response->assertSee('<meta name="robots" content="noindex, follow"/>', false);
        $response->assertSee('Back Home');
    }

    public function test_contact_form_stores_a_message(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
            'message' => 'Hi, I would like to discuss a project with you.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('messages', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
        ]);
    }

    public function test_contact_form_sends_a_copy_to_the_reply_inbox(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
            'message' => 'Hi, I would like to discuss a project with you.',
        ]);

        Mail::assertSent(ContactMessageReceived::class, function (ContactMessageReceived $mail) {
            return $mail->hasTo('michaelsogagbozo@gmail.com')
                && $mail->contactMessage->email === 'jane@example.com'
                && $mail->contactMessage->subject === 'Project enquiry';
        });
    }

    public function test_contact_form_sends_a_confirmation_to_the_visitor(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
            'message' => 'Hi, I would like to discuss a project with you.',
        ]);

        Mail::assertSent(ContactMessageConfirmation::class, function (ContactMessageConfirmation $mail) {
            return $mail->hasTo('jane@example.com')
                && $mail->contactMessage->name === 'Jane Visitor'
                && $mail->contactMessage->subject === 'Project enquiry';
        });
    }

    public function test_contact_form_still_succeeds_if_email_delivery_fails(): void
    {
        Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('SMTP is unavailable.'));

        $response = $this->post('/contact', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
            'message' => 'Hi, I would like to discuss a project with you.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('messages', [
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
        ]);
    }

    public function test_contact_form_rejects_invalid_input(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'subject' => '',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        $this->assertDatabaseCount('messages', 0);
    }
}
