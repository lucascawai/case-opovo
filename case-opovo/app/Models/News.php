<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $primaryKey = 'id';

    protected $fillable = ['journalist_id', 'news_type_id', 'title', 'description', 'content', 'thumbnail'];

    protected $casts = [
        'news_type_id' => 'integer'
    ];

    public function journalist()
    {
        return $this->belongsOne(Journalist::class);
    }

    public function newsType()
    {
        return $this->belongsOne(NewsType::class);
    }
}
