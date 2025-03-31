<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsType extends Model
{
    protected $table = 'news_type';

    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public function journalist() {
        return $this->hasOne(Journalist::class);
    }
}
