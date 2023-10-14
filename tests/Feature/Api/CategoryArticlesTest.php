<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryArticlesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_category_articles(): void
    {
        $category = Category::factory()->create();
        $articles = Article::factory()
            ->count(2)
            ->create([
                'category_id' => $category->id,
            ]);

        $response = $this->getJson(
            route('api.categories.articles.index', $category)
        );

        $response->assertOk()->assertSee($articles[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_category_articles(): void
    {
        $category = Category::factory()->create();
        $data = Article::factory()
            ->make([
                'category_id' => $category->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.categories.articles.store', $category),
            $data
        );

        $this->assertDatabaseHas('articles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $article = Article::latest('id')->first();

        $this->assertEquals($category->id, $article->category_id);
    }
}
