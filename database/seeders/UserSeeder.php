<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Hamcrest\Arrays\IsArray;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private function randomElements($arr, $maxElements)
    {
        $t = array_rand($arr, rand(1, $maxElements));
        if (!is_array($t))
            return [$arr[$t]];
            
        return array_map(fn($i) => $arr[$i], $t);
    }

    public function run()
    {
        $NUMUSERS = 10;
        $NUMADMINS = 3;
        $MAXNUMTAGS = 6;
        $categoryIds = Category::pluck('id')->toArray();
        $tagsIds = Tag::pluck('id')->toArray();

        User::factory($NUMADMINS) // create users with admin role
                ->create()
                ->each(function($admin) {
                    $admin->roles()->attach([2, 3]);
                });

        $users = User::factory($NUMUSERS)->create(); // create users
        $userIds = User::pluck('id')->toArray(); //TODO: filter only users?
        $users->each(function ($user) use ($categoryIds, $tagsIds, $MAXNUMTAGS, $userIds) {
            $user->roles()->attach([3]); // give it user role
            $numArticles = rand(0, 10);
            $catId = $categoryIds[array_rand($categoryIds)];
            Article::factory($numArticles)
                    ->create(['category_id' => $catId, 'user_id' => $user->id])
                    ->each(function ($article) use ($tagsIds, $MAXNUMTAGS, $userIds) {
                        $numComments = rand(0, 20);
                        $tags = $this->randomElements($tagsIds, $MAXNUMTAGS);
                        $article->tags()->attach($tags);
                        Comment::factory($numComments)
                                ->create(['article_id' => $article->id, 'user_id' => 1])
                                ->each(function($comment) use($userIds) {
                                    $comment->user_id = $userIds[array_rand($userIds)];
                                    $comment->save();
                                });
                    });
        });
    }
}
