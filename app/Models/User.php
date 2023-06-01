<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;



class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    protected $fillable = [
        'name', 'lastName', 'email', 'password','passConf'
    ];
    use HasFactory;
}
