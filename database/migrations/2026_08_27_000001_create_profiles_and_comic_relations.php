<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('phone')->nullable()->unique();
            $table->string('company_address')->nullable();
            $table->string('image')->nullable();
            $table->text('short_description')->nullable();
            $table->timestamps();
        });

        Schema::create('article_category', function (Blueprint $table) {
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->primary(['article_id', 'category_id']);
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('rivista_id')->nullable()->after('category_id')->constrained('riviste')->nullOnDelete();
        });

        DB::table('users')->orderBy('id')->each(function ($user) {
            DB::table('profiles')->insert([
                'user_id' => $user->id,
                'phone' => $user->phone,
                'company_address' => $user->company_address,
                'image' => $user->image,
                'short_description' => $user->short_description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        DB::table('articles')->whereNotNull('category_id')->orderBy('id')->each(function ($article) {
            DB::table('article_category')->insertOrIgnore([
                'article_id' => $article->id,
                'category_id' => $article->category_id,
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('rivista_id');
        });

        Schema::dropIfExists('article_category');
        Schema::dropIfExists('profiles');
    }
};
