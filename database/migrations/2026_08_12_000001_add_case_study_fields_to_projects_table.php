<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('client_name')->nullable()->after('meta');
            $table->string('project_year', 20)->nullable()->after('client_name');
            $table->json('services')->nullable()->after('project_year');
            $table->json('tech_stack')->nullable()->after('services');
            $table->text('challenge')->nullable()->after('tech_stack');
            $table->text('solution')->nullable()->after('challenge');
            $table->text('results')->nullable()->after('solution');
            $table->text('testimonial')->nullable()->after('results');
            $table->string('before_image')->nullable()->after('testimonial');
            $table->string('after_image')->nullable()->after('before_image');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'client_name',
                'project_year',
                'services',
                'tech_stack',
                'challenge',
                'solution',
                'results',
                'testimonial',
                'before_image',
                'after_image',
            ]);
        });
    }
};
