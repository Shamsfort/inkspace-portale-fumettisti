<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
    * Run the migrations.
    */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('username')->nullable()->onDelete('SET NULL');
            $table->string('surname')->nullable()->onDelete('SET NULL');
            $table->string('github')->nullable()->onDelete('SET NULL');
            $table->string('instagram')->nullable()->onDelete('SET NULL');
            $table->string('x')->nullable()->onDelete('SET NULL');

            
            
            
        });
    }
    
    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('username');
            $table->dropColumn('surname');
            $table->dropColumn('github');
            $table->dropColumn('instagram');
            $table->dropColumn('x');
        });
    }
};
