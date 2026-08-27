<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
    * Run the database seeds.
    */
    public function run(): void
    {
        Article::create([
            'title' => 'LA TUA CANZONE',
            'subtitle' => 'COEZ',
            'article_description' => 'Coez è il miglor Cantaautore Italiano di sempre. La sua musica è un mix di rock, pop e folk. Ecco una delle sue canzoni più famose "La tua canzone"',
            'comic_number' => '1',
            'comic_year' => '2019',
            'author_id' => 11,
            'category_id' => 1,
            //ORA INSERIAMO L'IMMAGINE presente sul nostro pc
            'image' => 'images/1717065933.jpg',
            
        ]);
        
        Article::create([
            'title' => 'QVC9',
            'subtitle' => 'QVC9 FA PAURA',
            'article_description' => 'Gemitaiz in arte "DAVIDE DE LUCA" è un rapper italiano. Ecco una dei sui MIXTAPE più famosi "QVC9"',
            'comic_number' => '2',
            'comic_year' => '2020',
            'author_id' => 11,
            'category_id' => 1,
            //ORA INSERIAMO L'IMMAGINE presente sul nostro pc
            'image' => 'images/1716902647.jpg',
            
        ]);
        
        
        Article::create([
            'title' => 'Starboy',
            'subtitle' => 'US',
            'article_description' => 'TheWeeknd e il suo album "Starboy" sta sfondando tutti i record di successo del suo genere. Ecco una delle sue canzoni più famosi "Starboy"',
            'comic_number' => '3',
            'comic_year' => '1934',
            'author_id' => 11,
            'category_id' => 1,
            //ORA INSERIAMO L'IMMAGINE presente sul nostro pc
            'image' => 'images/1716582302.jpg',
            
        ]);
    }
}
