<?php

namespace App\Repository;

use App\Model\TeacherModel;
use App\Model\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminRepository
{

    public function getPassword($id)
    {
        return DB::select("select password from admin where username ='" . $id . "'")[0]->password;
    }
}
