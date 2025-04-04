<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Journalist extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'journalists';

    protected $primaryKey = 'id';

    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function newsType()
    {
        return $this->hasMany(NewsType::class);
    }
}
