<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'UI/UX Designer',
                'slug' => 'ui-ux-designer',
            ],
            [
                'name' => 'Graphic Designer',
                'slug' => 'graphic-designer',
            ],
            [
                'name' => 'Laravel Developer',
                'slug' => 'laravel-developer',
            ],
            [
                'name' => 'Frontend Developer',
                'slug' => 'frontend-developer',
            ],
            [
                'name' => 'SEO Specialist',
                'slug' => 'seo-specialist',
            ],
            [
                'name' => 'Content Writer',
                'slug' => 'content-writer',
            ],
            [
                'name' => 'Photographer',
                'slug' => 'photographer',
            ],
            [
                'name' => 'Videographer',
                'slug' => 'videographer',
            ],
            [
                'name' => 'Video Editor',
                'slug' => 'video-editor',
            ],
            [
                'name' => 'Social Media Specialist',
                'slug' => 'social-media-specialist',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                [
                    'slug' => $role['slug'],
                ],
                [
                    'name' => $role['name'],
                    'is_active' => true,
                ]
            );
        }
    }
}