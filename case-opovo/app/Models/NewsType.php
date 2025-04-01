<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsType extends Model
{
    use HasFactory;

    protected $table = 'news_type';

    protected $primaryKey = 'id';

    protected $fillable = ['journalist_id', 'name'];

    public function journalist()
    {
        return $this->belongsTo(Journalist::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
