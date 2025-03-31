<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journalist extends Model
{
    protected $table = 'journalists';

    protected $primaryKey = 'id';

    protected $fillable = ['first_name', 'last_name', 'email', 'password'];
}
