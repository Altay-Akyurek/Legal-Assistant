<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Anayasa Maddeleri Model
 * Türkiye Cumhuriyeti Anayasası maddeleri
 */
class ConstitutionArticle extends Model
{
    protected $fillable = [
        'article_number',
        'title',
        'official_text',
        'simplified_explanation',
        'keywords',
        'order',
        'is_active',
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
        'article_number' => 'integer',
    ];

    /**
     * Bu maddeye ait hak kategorileri
     */
    public function rightCategories(): BelongsToMany
    {
        return $this->belongsToMany(
            RightCategory::class,
            'constitution_article_right_category'
        )->withPivot('relevance_score')->withTimestamps();
    }

    /**
     * Bu maddeyi destekleyen kanunlar
     */
    public function supportingLaws(): HasMany
    {
        return $this->hasMany(SupportingLaw::class);
    }

    /**
     * Aktif maddeleri getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Madde numarasına göre sırala
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('article_number');
    }

    /**
     * Anahtar kelimeye göre ara
     */
    public function scopeByKeyword($query, string $keyword)
    {
        return $query->whereJsonContains('keywords', $keyword)
            ->orWhere('title', 'like', "%{$keyword}%")
            ->orWhere('official_text', 'like', "%{$keyword}%");
    }
}
