<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add some tags to each post
        $postIds = DB::table('posts')->pluck('id')->toArray();
        $tagIds = DB::table('tags')->pluck('id')->toArray();

        if (empty($postIds) || empty($tagIds)) {
            return;
        }

        $postTags = [];

        foreach ($postIds as $postId) {
            // Associer entre 1 et 3 tags à chaque post
            $randomTags = array_rand($tagIds, rand(1, 3));

            foreach ((array) $randomTags as $tagIndex) {
                $postTags[] = [
                    'post_id' => $postId,
                    'tag_id' => $tagIds[$tagIndex],
                ];
            }
        }

        DB::table('post_tag')->insert($postTags);
    }
}
