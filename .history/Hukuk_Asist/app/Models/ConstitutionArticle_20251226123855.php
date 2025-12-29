<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
/*
Anayasa Maddeleri  
*/
/* 
Türkiye Cumhuriyet Anayasası Maddeleri 
*/
class ConstitutionArticle extends Model
{
    protected $fillable=[
        'article_number',
        'title',
        'official_text',
        'simplified_explanation',,
    ]
}
