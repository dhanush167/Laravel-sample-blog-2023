<?php

namespace Tests\Feature\Api;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTagsTest extends TestCase
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
    public function it_gets_article_tags(): void
    {
        $article = Article::factory()->create();
        $tag = Tag::factory()->create();

        $article->tags()->attach($tag);

        $response = $this->getJson(route('api.articles.tags.index', $article));

        $response->assertOk()->assertSee($tag->name);
    }

    /**
     * @test
     */
    public function it_can_attach_tags_to_article(): void
    {
        $article = Article::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->postJson(
            route('api.articles.tags.store', [$article, $tag])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $article
                ->tags()
                ->where('tags.id', $tag->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_tags_from_article(): void
    {
        $article = Article::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->deleteJson(
            route('api.articles.tags.store', [$article, $tag])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $article
                ->tags()
                ->where('tags.id', $tag->id)
                ->exists()
        );
    }
}
