<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageConfirmation;
use App\Mail\ContactMessageReceived;
use App\Models\Design;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PortfolioController extends Controller
{
    public function home()
    {
        $designProjects = Project::where('category', 'design')->where('active', true)->orderBy('id', 'desc')->get();
        $devProjects    = Project::where('category', 'development')->where('active', true)->orderBy('id', 'desc')->get();
        $designs        = Design::orderBy('id', 'desc')->get();

        return view('home', compact('designProjects', 'devProjects', 'designs'));
    }

    public function project(Project $project)
    {
        // The "Active/Inactive" toggle in the dashboard is meant to hide a
        // project from the public site entirely — without this check, an
        // "inactive" project would still be reachable by its direct URL.
        abort_unless($project->active, 404);

        return view('project', compact('project'));
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
