<?php

namespace Tests\Feature\Api;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagArticlesTest extends TestCase
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
    public function it_gets_tag_articles(): void
    {
        $tag = Tag::factory()->create();
        $article = Article::factory()->create();

        $tag->articles()->attach($article);

        $response = $this->getJson(route('api.tags.articles.index', $tag));

        $response->assertOk()->assertSee($article->title);
    }

    /**
     * @test
     */
    public function it_can_attach_articles_to_tag(): void
    {
        $tag = Tag::factory()->create();
        $article = Article::factory()->create();

        $response = $this->postJson(
            route('api.tags.articles.store', [$tag, $article])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $tag
                ->articles()
                ->where('articles.id', $article->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_articles_from_tag(): void
    {
        $tag = Tag::factory()->create();
        $article = Article::factory()->create();

        $response = $this->deleteJson(
            route('api.tags.articles.store', [$tag, $article])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $tag
                ->articles()
                ->where('articles.id', $article->id)
                ->exists()
        );
    }
}
