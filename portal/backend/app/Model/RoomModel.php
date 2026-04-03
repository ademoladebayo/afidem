<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Model\UserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomModel extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;
    protected $table = 'service_room';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'user_id');
    }

}
