<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Authenticatable
{
    use  Notifiable, HasApiTokens, SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
