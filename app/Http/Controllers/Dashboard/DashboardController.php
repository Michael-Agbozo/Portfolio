<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\Message;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'designs'  => Design::count(),
            'messages' => Message::count(),
            'unread'   => Message::whereNull('read_at')->count(),
        ];

        $recentMessages = Message::latest()->take(5)->get();

        return view('dashboard.index', compact('stats', 'recentMessages'));
    }
}
