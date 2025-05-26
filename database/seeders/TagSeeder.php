<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        $tags = [
            [
                'name' => 'Nouveau',
                'slug' => 'nouveau',
                'description' => 'Produits récemment ajoutés à notre collection',
                'is_active' => true,
                'sort_order' => 1,
                'color_code' => '#4CAF50',
                'icon' => 'sparkles',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tendance',
                'slug' => 'tendance',
                'description' => 'Les styles les plus populaires du moment',
                'is_active' => true,
                'sort_order' => 2,
                'color_code' => '#FF5722',
                'icon' => 'trending-up',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Promotion',
                'slug' => 'promotion',
                'description' => 'Articles à prix réduit pour une durée limitée',
                'is_active' => true,
                'sort_order' => 3,
                'color_code' => '#F44336',
                'icon' => 'tag',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Soldes',
                'slug' => 'soldes',
                'description' => 'Articles en solde avec des réductions importantes',
                'is_active' => true,
                'sort_order' => 4,
                'color_code' => '#E91E63',
                'icon' => 'percent',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Édition Limitée',
                'slug' => 'edition-limitee',
                'description' => 'Articles exclusifs disponibles en quantité limitée',
                'is_active' => true,
                'sort_order' => 5,
                'color_code' => '#9C27B0',
                'icon' => 'award',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Meilleure Vente',
                'slug' => 'meilleure-vente',
                'description' => 'Nos produits les plus populaires et les plus vendus',
                'is_active' => true,
                'sort_order' => 6,
                'color_code' => '#3F51B5',
                'icon' => 'star',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Eco-responsable',
                'slug' => 'eco-responsable',
                'description' => 'Produits fabriqués avec des matériaux durables et respectueux de l\'environnement',
                'is_active' => true,
                'sort_order' => 7,
                'color_code' => '#8BC34A',
                'icon' => 'leaf',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Fait Main',
                'slug' => 'fait-main',
                'description' => 'Produits artisanaux fabriqués à la main avec soin',
                'is_active' => true,
                'sort_order' => 8,
                'color_code' => '#795548',
                'icon' => 'tool',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Confort',
                'slug' => 'confort',
                'description' => 'Chaussures conçues pour un confort optimal',
                'is_active' => true,
                'sort_order' => 9,
                'color_code' => '#00BCD4',
                'icon' => 'cloud',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Imperméable',
                'slug' => 'impermeable',
                'description' => 'Chaussures résistantes à l\'eau pour les jours de pluie',
                'is_active' => true,
                'sort_order' => 10,
                'color_code' => '#2196F3',
                'icon' => 'droplet',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Cuir Véritable',
                'slug' => 'cuir-veritable',
                'description' => 'Produits fabriqués en cuir authentique de haute qualité',
                'is_active' => true,
                'sort_order' => 11,
                'color_code' => '#9E9E9E',
                'icon' => 'shield',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Collection Été',
                'slug' => 'collection-ete',
                'description' => 'Chaussures légères et respirantes pour la saison estivale',
                'is_active' => true,
                'sort_order' => 12,
                'color_code' => '#FFEB3B',
                'icon' => 'sun',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Collection Hiver',
                'slug' => 'collection-hiver',
                'description' => 'Chaussures chaudes et isolantes pour la saison hivernale',
                'is_active' => true,
                'sort_order' => 13,
                'color_code' => '#607D8B',
                'icon' => 'snowflake',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Unisexe',
                'slug' => 'unisexe',
                'description' => 'Modèles convenant aussi bien aux hommes qu\'aux femmes',
                'is_active' => true,
                'sort_order' => 14,
                'color_code' => '#673AB7',
                'icon' => 'users',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Enfants',
                'slug' => 'enfants',
                'description' => 'Chaussures spécialement conçues pour les enfants',
                'is_active' => true,
                'sort_order' => 15,
                'color_code' => '#FF9800',
                'icon' => 'smile',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        // Insert all tags at once
        DB::table('tags')->insert($tags);
    }
}