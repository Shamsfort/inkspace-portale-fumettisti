<?php

namespace Tests\Feature;

use App\Mail\ContactMessageMail;
use App\Models\Article;
use App\Models\Category;
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
    }
}
