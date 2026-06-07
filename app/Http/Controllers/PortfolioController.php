<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        Message::create($validated);

        return back()->with('success', 'Message sent! I\'ll get back to you soon.');
    }
}
