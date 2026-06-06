<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Design;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function index()
    {
        $designs = Design::orderBy('sort_order')->orderBy('id')->get();
        return view('dashboard.designs.index', compact('designs'));
    }

    public function create()
    {
        return view('dashboard.designs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'src'        => 'required|url|max:500',
            'alt'        => 'required|string|max:200',
            'sort_order' => 'nullable|integer',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? Design::max('sort_order') + 1;

        Design::create($data);

        return redirect()->route('dashboard.designs.index')->with('success', 'Design added.');
    }

    public function destroy(Design $design)
    {
        $design->delete();
        return redirect()->route('dashboard.designs.index')->with('success', 'Design removed.');
    }
}
