<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Riviste extends Model
{
    use HasFactory;
    
        /**
        * The table associated with the model.
        *
        * @var string
        */
        protected $table = 'riviste';

        protected $fillable = ['nome', 'nazione'];

        public function articles(): HasMany
        {
            return $this->hasMany(Article::class, 'rivista_id');
        }
    
}
