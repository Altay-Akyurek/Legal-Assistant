<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Hak Kategorileri Model
 * Temel hak ve özgürlüklerin kategorize edilmesi
 */
class RightCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'detailed_guide',
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
     * Bu kategoriye ait anayasa maddeleri
     */
    public function constitutionArticles(): BelongsToMany
    {
        return $this->belongsToMany(
            ConstitutionArticle::class,
            'constitution_article_right_category'
        )->withPivot('relevance_score')->withTimestamps();
    }

    /**
     * Aktif kategorileri getir
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
        return $query->orderBy('order')->orderBy('name');
    }
}
