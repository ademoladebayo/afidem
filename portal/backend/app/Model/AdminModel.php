<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminModel extends Authenticatable
{
    use  Notifiable, HasApiTokens;
    protected $table = 'admin_station';
    protected $primaryKey = 'id';
    public $timestamps = false;



    protected $hidden = ['password'];
}
