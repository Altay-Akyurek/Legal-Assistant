<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/* Destekleyici Kanunlar 
Anayasa Maddeleri destekleyen kanunlar(bilgilendirme amaçlıdır) */
class SupportingLaw extends Model
{
    protected $fillable = [
        'constitution_article_id',
        'law_name',
        'law_number',
        'relavant_articles',
        'description',
        'keywords',
        'order',
        'is_active',
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
    public function constitutionArticle(): BelongsTo
    {
        return $this->belongsTo(ConstitutionArticle::class);
    }
}
