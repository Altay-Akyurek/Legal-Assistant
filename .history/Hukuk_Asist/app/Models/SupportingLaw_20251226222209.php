<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Destekleyici Kanunlar Model
 * Anayasa maddelerini destekleyen kanunlar (bilgilendirme amaçlı)
 */
class SupportingLaw extends Model
{
    protected $fillable = [
        'constitution_article_id',
        'law_name',
        'law_number',
        'relevant_articles',
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

    /**
     * İlişkili anayasa maddesi
     */
    public function constitutionArticle(): BelongsTo
    {
        return $this->belongsTo(ConstitutionArticle::class);
    }

    /**
     * Aktif kanunları getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Sıralı getir
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('law_name');
    }
}
