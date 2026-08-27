<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];
    
    
    // //!Vecchia versione
    
    //     // public function articles()
    //     // {
        //     //     return $this->hasMany(Article::class, 'category_id', 'id');
        //     // }
        
        //     //!New version
        public function articles(): BelongsToMany
        {
            return $this->belongsToMany(Article::class);
        }
    }
