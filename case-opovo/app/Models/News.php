<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news_type';

    protected $primaryKey = 'id';

    protected $fillable = ['title', 'description', 'content', 'thumbnail'];

    public function journalist() {
        return $this->hasOne(Journalist::class);
    }

    public function newsType() {
        return $this->hasOne(NewsType::class);
    }
}
