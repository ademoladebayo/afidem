<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseModel extends Authenticatable
{
    use  Notifiable, HasApiTokens, SoftDeletes;
    protected $table = 'expense_history';
    protected $primaryKey = 'id';
    public $timestamps = false;

    // public function pay_by()
    // {
    //     return $this->hasOne(ClassModel::class, 'id', 'class');
    // }
}
