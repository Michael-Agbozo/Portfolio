<?php

namespace Database\Seeders;

use App\Models\Design;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'agbozomykell8@gmail.com'],
            [
                'name'     => 'Michael Agbozo',
                'password' => Hash::make('password'),
            ]
        );

        if (Project::count() === 0) {
            $projects = [
                ['num' => '01 — Featured', 'title' => 'La Necar Logistics',  'meta' => 'Brand identity design + website build for a logistics company', 'tags' => ['Brand Identity', 'WordPress', 'Web Design'], 'url' => null,                           'sort_order' => 1],
                ['num' => '02',            'title' => 'Anha Churches',        'meta' => 'Transformed a small church\'s online presence — anhachurches.org',    'tags' => ['WordPress', 'Web Design'],               'url' => 'https://anhachurches.org',     'sort_order' => 2],
                ['num' => '03',            'title' => 'Poetic Koncept',        'meta' => 'Creative brand website — poetickoncept.com',                           'tags' => ['WordPress', 'Brand Design'],             'url' => 'https://poetickoncept.com',    'sort_order' => 3],
                ['num' => '04',            'title' => 'Hotto',                 'meta' => 'UI/UX design — web and mobile concept',                                'tags' => ['UI Design', 'UX', 'Mobile'],             'url' => null,                           'sort_order' => 4],
            ];

            foreach ($projects as $p) {
                Project::create($p);
            }
        }

        if (Design::count() === 0) {
            $base = 'https://cdn.prod.website-files.com/62a9f62ed52efb5544ca5d1e/';
            $designs = [
                ['src' => $base.'63936ddcca7061f2b3933152_IPMC%20%20PRACTICAL%20TAST%202%20a-min.jpg', 'alt' => 'IPMC Practical Task'],
                ['src' => $base.'62ab441b134cd2eb83f25595_easter%20con%202.jpg',                        'alt' => 'Easter Conference'],
                ['src' => $base.'62ab41626981126ee38c3806_Extra%20time%20of%20love%20N.jpg',            'alt' => 'Extra Time of Love'],
                ['src' => $base.'62ab43c10e9f9005dd1a2c68_new%202.jpg',                                'alt' => 'Design Work'],
                ['src' => $base.'62ab41d2ff6ad53406cc752f_Zin%27s.jpg',                                'alt' => "Zin's Design"],
                ['src' => $base.'62ab42d58140e33184b75d97_new%201.jpg',                                'alt' => 'Design Work'],
                ['src' => $base.'62ab445478fa468dd8dc131c_bda.jpg',                                    'alt' => 'BDA Design'],
                ['src' => $base.'62ab44c4af404ffdf0c7c86f_new%203.jpg',                                'alt' => 'Design Work'],
                ['src' => $base.'62d44a2dcc6dd8e8bebc0bfb_Community%20Evangelism.jpg',                 'alt' => 'Community Evangelism'],
                ['src' => $base.'62d44b336105de89d83df202_Ayeyi%20short%20shirt%205.jpg',              'alt' => 'Ayeyi Design'],
                ['src' => $base.'62d44ace5d3ddb6a2f92f0a1_ShemaFEST%202.jpg',                          'alt' => 'ShemaFEST'],
                ['src' => $base.'69cd71300ac1c407e724cd07_THEO%20NOV.%202025.jpg',                     'alt' => 'THEO November 2025'],
                ['src' => $base.'6393692f8c3928784147fadf_new%20kk%202.jpg',                           'alt' => 'Design Work'],
                ['src' => $base.'639369312b044321f8db3ae2_CODING%20FOR%20KIDS%202.0.jpg',              'alt' => 'Coding for Kids 2.0'],
                ['src' => $base.'69cd712a6d4c52d7c444cc52_NALAG.jpg',                                  'alt' => 'NALAG'],
                ['src' => $base.'69cd74e96023822357e60e66_gpc%202025.jpg',                             'alt' => 'GPC 2025'],
                ['src' => $base.'62d44af3b7f9bc5792348037_wordplay%20award%20new.jpg',                 'alt' => 'Wordplay Award'],
                ['src' => $base.'63936a294891cf31b69f0327_breakfast%20feast%202.0.jpg',                'alt' => 'Breakfast Feast 2.0'],
                ['src' => $base.'63936a9c5b8327a4e01684af_Conviction.jpg',                             'alt' => 'Conviction'],
            ];

            foreach ($designs as $i => $d) {
                Design::create(array_merge($d, ['sort_order' => $i + 1]));
            }
        }
    }
}
