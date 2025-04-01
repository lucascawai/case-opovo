<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Journalist extends Authenticatable implements JWTSubject
{
    protected $table = 'journalists';

    protected $primaryKey = 'id';

    protected $fillable = ['first_name', 'last_name', 'email'];

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
