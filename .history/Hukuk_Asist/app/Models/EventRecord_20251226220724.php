<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Olay Kayıtları Model
 * Kullanıcıların girdiği olaylar (anonim, KVKK uyumlu)
 */
class EventRecord extends Model
{
    protected $fillable = [
        'event_description',
        'detected_keywords',
        'detected_right_categories',
        'matched_articles',
        'ip_address',
        'session_id',
        'analyzed_at',
    ];

    protected $casts = [
        'detected_keywords' => 'array',
        'detected_right_categories' => 'array',
        'matched_articles' => 'array',
        'analyzed_at' => 'datetime',
    ];

    /**
     * IP adresini anonimleştir (KVKK uyumluluğu için)
     */
    public function setIpAddressAttribute($value)
    {
        if ($value) {
            // Son okteti sıfırla (anonimleştir)
            $parts = explode('.', $value);
            if (count($parts) === 4) {
                $parts[3] = '0';
                $this->attributes['ip_address'] = implode('.', $parts);
            } else {
                $this->attributes['ip_address'] = $value;
            }
        }
    }
}
