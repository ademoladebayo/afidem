<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ActivityLogModel extends Model{

    use SoftDeletes;
    protected $table = 'activity_log';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
