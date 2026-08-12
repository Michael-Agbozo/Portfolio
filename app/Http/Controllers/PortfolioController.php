<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageConfirmation;
use App\Mail\ContactMessageReceived;
use App\Models\Design;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PortfolioController extends Controller
{
    private const SERVICES = [
        'laravel-development-ghana' => [
            'name' => 'Laravel Development in Ghana & Remote',
            'short_name' => 'Laravel Development',
            'meta_title' => 'Remote Laravel Developer in Ghana | Michael Agbozo',
            'meta_description' => 'Hire Michael Agbozo for Laravel development in Ghana and remotely: custom web apps, dashboards, admin portals, backend features, and support.',
            'summary' => 'Custom Laravel applications, dashboards, admin portals, and backend features for businesses that need reliable systems instead of fragile workarounds.',
            'intro' => 'I build Laravel applications that are practical, maintainable, and easy for teams to use. That can mean a private dashboard, a custom workflow tool, a client portal, or backend improvements for an existing platform.',
            'audience' => 'Best for businesses, logistics teams, schools, churches, agencies, and growing operations that need a custom web system built around their real process.',
            'outcomes' => [
                'Custom Laravel dashboards and admin panels',
                'Secure forms, user accounts, roles, and permissions',
                'Database-backed workflows for daily operations',
                'Bug fixing, feature upgrades, and long-term support',
                'Clean deployment support for production hosting',
            ],
            'keywords' => [
                'Laravel developer Ghana',
                'remote Laravel developer',
                'Laravel web application Ghana',
                'custom dashboard developer',
                'remote backend developer',
            ],
            'faq' => [
                [
                    'question' => 'Do you build Laravel applications from scratch?',
                    'answer' => 'Yes. I can plan, build, deploy, and support a Laravel application from the first idea through launch.',
                ],
                [
                    'question' => 'Can you improve an existing Laravel project?',
                    'answer' => 'Yes. I can review an existing Laravel codebase, fix bugs, add features, improve forms, and clean up user-facing workflows.',
                ],
                [
                    'question' => 'Do you work with clients outside Ghana?',
                    'answer' => 'Yes. I am based in Ghana and available for remote web development projects.',
                ],
            ],
        ],
        'wordpress-website-design-ghana' => [
            'name' => 'WordPress Website Design in Ghana & Remote',
            'short_name' => 'WordPress Websites',
            'meta_title' => 'Remote WordPress Website Designer | Michael Agbozo',
            'meta_description' => 'WordPress website design in Ghana and remotely for businesses, brands, and organizations that need fast, clean, responsive websites with support.',
            'summary' => 'Business websites, landing pages, and portfolio sites built with WordPress, clear content structure, responsive design, and launch support.',
            'intro' => 'I design and build WordPress websites that are simple to manage, fast to load, and clear for visitors. The goal is a site that explains what you do, builds trust, and makes it easy for people to contact you.',
            'audience' => 'Best for small businesses, personal brands, logistics companies, service providers, churches, schools, and organizations that need a professional online presence.',
            'outcomes' => [
                'Responsive WordPress website design',
                'Homepage, service pages, contact pages, and portfolio sections',
                'Content structure that helps visitors understand your offer',
                'Basic SEO setup, analytics, and Google-friendly metadata',
                'Launch support and practical website maintenance',
            ],
            'keywords' => [
                'WordPress designer Ghana',
                'remote WordPress designer',
                'website designer Ghana',
                'remote website designer',
                'responsive website design',
            ],
            'faq' => [
                [
                    'question' => 'Can you build a full WordPress site for my business?',
                    'answer' => 'Yes. I can design, build, launch, and help maintain a WordPress website for your business or organization.',
                ],
                [
                    'question' => 'Will the website work on phones?',
                    'answer' => 'Yes. Every website is built to work well on mobile, tablet, and desktop screens.',
                ],
                [
                    'question' => 'Can you help with SEO and Google Analytics?',
                    'answer' => 'Yes. I can add basic SEO metadata, sitemap support, Search Console verification, and Google Analytics tracking.',
                ],
            ],
        ],
        'brand-identity-design-ghana' => [
            'name' => 'Brand Identity Design in Ghana & Remote',
            'short_name' => 'Brand Identity Design',
            'meta_title' => 'Remote Brand Identity Designer | Michael Agbozo',
            'meta_description' => 'Brand identity design in Ghana and remotely: logos, colors, typography, social media visuals, print materials, and brand systems by Michael Agbozo.',
            'summary' => 'Logo design, brand identity systems, social media visuals, and print-ready materials for businesses that need to look consistent and trustworthy.',
            'intro' => 'I create brand identity systems that help businesses look clear, consistent, and professional across digital and print touchpoints. The work can include logos, colors, type, social media templates, and campaign visuals.',
            'audience' => 'Best for new businesses, growing brands, service companies, logistics brands, churches, events, and teams that need stronger visual consistency.',
            'outcomes' => [
                'Logo and visual identity design',
                'Color palette, typography, and brand direction',
                'Social media designs and campaign graphics',
                'Print materials such as flyers, banners, and brochures',
                'Brand assets prepared for web and marketing use',
            ],
            'keywords' => [
                'brand designer Ghana',
                'remote brand identity designer',
                'logo designer Ghana',
                'brand identity design',
                'remote social media designer',
            ],
            'faq' => [
                [
                    'question' => 'Do you design logos?',
                    'answer' => 'Yes. I design logos as part of a wider brand identity so the logo, colors, type, and visuals work together.',
                ],
                [
                    'question' => 'Can you design social media graphics too?',
                    'answer' => 'Yes. I can create social media post designs, campaign visuals, and reusable visual templates.',
                ],
                [
                    'question' => 'Can the brand assets be used on a website?',
                    'answer' => 'Yes. I prepare brand assets for digital use, including websites, social media, and marketing materials.',
                ],
            ],
        ],
        'it-systems-support-ghana' => [
            'name' => 'IT Systems Support in Ghana & Remote',
            'short_name' => 'IT Systems Support',
            'meta_title' => 'Remote IT Systems Support | Michael Agbozo',
            'meta_description' => 'IT systems support in Ghana and remotely for email setup, user access, help desk workflows, internal tools, telecom support, and staff operations.',
            'summary' => 'Hands-on IT systems support, email setup, access management, help desk workflows, telecom coordination, and internal tool support for teams.',
            'intro' => 'I support the technology behind daily operations: staff accounts, email, access, internal tools, troubleshooting, telecom setup, and practical systems that keep teams moving.',
            'audience' => 'Best for organizations and operations teams that need dependable IT support, cleaner internal processes, and someone who understands both systems and people.',
            'outcomes' => [
                'Email and user account setup',
                'Access management and staff onboarding support',
                'Help desk troubleshooting and issue tracking',
                'Telecom and device coordination',
                'Internal workflow and systems improvement',
            ],
            'keywords' => [
                'IT support Ghana',
                'remote IT support',
                'systems administrator Ghana',
                'remote help desk support',
                'business IT support',
            ],
            'faq' => [
                [
                    'question' => 'Do you provide IT support for teams?',
                    'answer' => 'Yes. I support staff technology needs including email, accounts, access, troubleshooting, and internal systems.',
                ],
                [
                    'question' => 'Can you help set up internal tools?',
                    'answer' => 'Yes. I can help plan and support tools that make daily operations easier and more organized.',
                ],
                [
                    'question' => 'Do you combine IT support with web development?',
                    'answer' => 'Yes. My work often connects IT operations with Laravel, WordPress, dashboards, and internal systems.',
                ],
            ],
        ],
    ];

    public function home()
    {
        $designProjects = Project::where('category', 'design')->where('active', true)->orderBy('id', 'desc')->get();
        $devProjects    = Project::where('category', 'development')->where('active', true)->orderBy('id', 'desc')->get();
        $designs        = Design::orderBy('id', 'desc')->get();

        $services = self::SERVICES;

        return view('home', compact('designProjects', 'devProjects', 'designs', 'services'));
    }

    public function project(Project $project)
    {
        // The "Active/Inactive" toggle in the dashboard is meant to hide a
        // project from the public site entirely — without this check, an
        // "inactive" project would still be reachable by its direct URL.
        abort_unless($project->active, 404);

        return view('project', compact('project'));
    }

    public function service(string $service)
    {
        abort_unless(array_key_exists($service, self::SERVICES), 404);

        $service = self::SERVICES[$service] + ['slug' => $service];
        $relatedProjects = Project::where('active', true)
            ->latest()
            ->take(3)
            ->get();

        return view('service', compact('service', 'relatedProjects'));
    }

    public function robots(): Response
    {
        return response(file_get_contents(public_path('robots.txt')), 200)
            ->header('Content-Type', 'text/plain');
    }

    public function sitemap(): Response
    {
        $projects = Project::where('active', true)
            ->orderByDesc('updated_at')
            ->get(['title', 'slug', 'updated_at']);

        $services = self::SERVICES;

        return response()
            ->view('sitemap', compact('projects', 'services'))
            ->header('Content-Type', 'application/xml');
    }

    public function sendContact(Request $request)
    {
        // Honeypot: real visitors never see or fill in the "website" field.
        // If it has a value, the submission is almost certainly from a bot —
        // pretend it succeeded so the bot doesn't keep retrying, but don't
        // save the message or send any emails.
        if ($request->filled('website')) {
            return back()->with('success', 'Message sent! I\'ll get back to you soon.');
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        $message = Message::create($validated);

        try {
            Mail::to(config('mail.contact_recipient'))->send(new ContactMessageReceived($message));
            Mail::to($message->email)->send(new ContactMessageConfirmation($message));
        } catch (Throwable $exception) {
            Log::warning('Contact message saved, but email delivery failed.', [
                'message_id' => $message->id,
                'error' => $exception->getMessage(),
            ]);
        }

        return back()->with('success', 'Message sent! I\'ll get back to you soon.');
    }
}
