<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class TransactionModel extends Authenticatable
{
    use  Notifiable, HasApiTokens;
    protected $table = 'transaction_history';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
