<?php

namespace Tests\Feature;

use App\Mail\ContactMessageMail;
use App\Models\AdminRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\CommunityPost;
use App\Models\ContactMessage;
use App\Models\Riviste;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortalRequirementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_browse_comics_and_artists(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['short_description' => 'Autore indipendente']);
        $article = Article::create([
            'title' => 'Nebula',
            'article_description' => 'Una storia abbastanza lunga per il test.',
            'comic_number' => 1,
            'comic_year' => 2026,
            'author_id' => $user->id,
            'is_accepted' => true,
        ]);

        $this->get(route('article.index'))->assertOk()->assertSee('Nebula');
        $this->get(route('article.show', $article))->assertOk()->assertSee('Nebula');
        $this->get(route('profile.index'))->assertOk()->assertSee($user->name);
        $this->get(route('profile.user', $user))->assertOk()->assertSee('Nebula');
    }

    public function test_registration_creates_a_separate_profile(): void
    {
        $this->post('/register', [
            'name' => 'Valeria',
            'username' => 'ValeInk',
            'email' => 'valeria@example.com',
            'phone' => '+39 333 1234567',
            'company_address' => 'Via delle Tavole 1',
            'short_description' => 'Fumettista in erba',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect('/');

        $this->assertDatabaseHas('users', ['email' => 'valeria@example.com']);
        $this->assertDatabaseHas('profiles', ['phone' => '+39 333 1234567']);
    }

    public function test_authenticated_user_can_publish_with_categories_and_magazine(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $categoryA = Category::create(['name' => 'Fantasy']);
        $categoryB = Category::create(['name' => 'Avventura']);
        $rivista = Riviste::create(['nome' => 'Shonen Jump', 'nazione' => 'JP']);

        $response = $this->actingAs($user)->post(route('article.store'), [
            'title' => 'Oltre il segno',
            'subtitle' => 'Volume uno',
            'article_description' => 'Una trama avventurosa lunga abbastanza.',
            'comic_number' => 1,
            'comic_year' => 2026,
            'image' => UploadedFile::fake()->image('cover.jpg'),
            'categories' => [$categoryA->id, $categoryB->id],
            'rivista_id' => $rivista->id,
        ]);

        $article = Article::where('title', 'Oltre il segno')->firstOrFail();
        $response->assertRedirect(route('article.show', $article));
        $this->assertSame($user->id, $article->author_id);
        $this->assertSame($rivista->id, $article->rivista_id);
        $this->assertCount(2, $article->categories);
        Storage::disk('public')->assertExists($article->image);
    }

    public function test_blob_urls_are_rendered_without_local_storage_prefix(): void
    {
        $article = new Article([
            'image' => 'https://example.public.blob.vercel-storage.com/covers/test.jpg',
        ]);

        $this->assertSame($article->image, $article->image_url);
    }

    public function test_only_the_author_can_edit_or_delete_a_comic(): void
    {
        $author = User::factory()->create();
        $intruder = User::factory()->create();
        $article = Article::create([
            'title' => 'Protetto',
            'article_description' => 'Una descrizione sufficientemente lunga.',
            'comic_number' => 1,
            'comic_year' => 2026,
            'author_id' => $author->id,
            'is_accepted' => true,
        ]);

        $this->actingAs($intruder)->get(route('article.edit', $article))->assertForbidden();
        $this->actingAs($intruder)->delete(route('article.destroy', $article))->assertForbidden();
        $this->assertDatabaseHas('articles', ['id' => $article->id]);
    }

    public function test_contact_form_sends_admin_message_and_confirmation(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), [
            'name' => 'Mario',
            'email' => 'mario@example.com',
            'message' => 'Vorrei maggiori informazioni sul portale.',
        ])->assertSessionHas('message');

        Mail::assertSent(ContactMessageMail::class, 2);
        $this->assertDatabaseHas('contact_messages', ['email' => 'mario@example.com', 'status' => 'open']);
    }

    public function test_authenticated_user_can_create_a_pending_community_post(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('community.store'), [
            'body' => 'Questo è un post della community con foto.',
            'images' => [
                UploadedFile::fake()->image('post.jpg'),
            ],
        ]);

        $response->assertRedirect(route('community.index'));
        $this->assertDatabaseHas('community_posts', [
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
        $post = CommunityPost::where('user_id', $user->id)->firstOrFail();
        $this->assertCount(1, $post->images);
    }

    public function test_community_rejects_more_than_three_images(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('community.store'), [
            'body' => 'Questo post prova a superare il limite consentito.',
            'images' => collect(range(1, 4))->map(fn ($number) => UploadedFile::fake()->image("post-{$number}.jpg"))->all(),
        ])->assertSessionHasErrors('images');

        $this->assertDatabaseCount('community_posts', 0);
    }

    public function test_pending_post_is_hidden_until_an_admin_approves_it(): void
    {
        $author = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        $post = CommunityPost::create(['user_id' => $author->id, 'body' => 'Post in attesa di moderazione.', 'status' => 'pending']);

        $this->get(route('community.show', $post))->assertNotFound();
        $this->actingAs($admin)->patch(route('community-admin.posts.approve', $post))->assertSessionHas('message');
        $this->get(route('community.show', $post))->assertOk();
        $this->assertDatabaseHas('community_posts', ['id' => $post->id, 'status' => 'approved', 'reviewed_by' => $admin->id]);
    }

    public function test_rejected_admin_request_can_be_submitted_again_and_approved_atomically(): void
    {
        $candidate = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        $request = AdminRequest::create(['user_id' => $candidate->id, 'status' => 'rejected']);

        $this->actingAs($candidate)->post(route('community.request-admin'))->assertSessionHas('message');
        $this->assertDatabaseHas('admin_requests', ['id' => $request->id, 'status' => 'pending']);

        $this->actingAs($admin)->patch(route('community-admin.admin-requests.approve', $request->fresh()))->assertSessionHas('message');
        $this->assertTrue($candidate->fresh()->is_admin);
        $this->assertDatabaseHas('admin_requests', ['id' => $request->id, 'status' => 'approved']);
    }
}

