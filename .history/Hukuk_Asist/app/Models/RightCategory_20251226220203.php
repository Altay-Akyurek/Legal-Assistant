<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/* 
Hak Kategorileri Model
Temel Hak ve Özgürlük kategorize edilmeli  
*/
class RightCategory extends Model
{
    protected $fillable= [
        'name',
        'slug',
        'description',
        'keywords',
        'order',
        'is_active',
    ];

    protected $casts =[
        'keywords'=>'array',
        'is_active'=>'boolean',
        'order'=>'integer',
    ];

    public function constitutionArticles():BelongsToMany
    {
        return $this->belongsToMany(
            ConstitutionArticle :: class,
            'constitution_article_right_category'
            
        )->withWhereRelation
    }
}
