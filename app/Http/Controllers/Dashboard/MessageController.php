<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        return view('dashboard.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        $message->markRead();
        return view('dashboard.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('dashboard.messages.index')->with('success', 'Message deleted.');
    }
}
