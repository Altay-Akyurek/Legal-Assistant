<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/* Olay Kayıtları Model
kullanıcınların girdiği olaylar(anonim KVKK uyumlu)
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
        'analtzed_at',
    ];

    protected $casts = [
        'detected_keywords' => 'arry',
        'detected_right_categories' => 'array',
        'matched_articles' => 'array',
        'analyzed_at' => 'datetime',

    ];
}
