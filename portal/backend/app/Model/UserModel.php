<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use  Notifiable, HasApiTokens;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
