<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        // Fill in slugs for any projects that already exist, making sure
        // each one is unique (e.g. "my-project", "my-project-2", ...).
        $usedSlugs = [];

        foreach (\Illuminate\Support\Facades\DB::table('projects')->orderBy('id')->get() as $project) {
            $base = Str::slug($project->title) ?: 'project';
            $slug = $base;
            $suffix = 2;

            while (in_array($slug, $usedSlugs, true)) {
                $slug = $base.'-'.$suffix++;
            }

            $usedSlugs[] = $slug;

            \Illuminate\Support\Facades\DB::table('projects')->where('id', $project->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
