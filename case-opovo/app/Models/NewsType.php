<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsType extends Model
{
    protected $table = 'news_type';

    protected $primaryKey = 'id';

    protected $fillable = ['journalist_id', 'name'];

    public function journalist()
    {
        return $this->belongsOne(Journalist::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
