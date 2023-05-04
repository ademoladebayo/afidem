<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;


class ActivityLogModel extends Model{

    protected $table = 'activity_log';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
