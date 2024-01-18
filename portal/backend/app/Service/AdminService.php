<?php

namespace App\Service;

use App\Model\ClassModel;
use App\Model\SubjectModel;
use App\Model\StudentModel;
use App\Model\AdminModel;
use App\Model\ControlPanelModel;
use App\Model\InventoryModel;
use App\Model\LessonPlanModel;
use App\Model\TeacherModel;
use App\Model\TeacherAttendanceModel;
use App\Model\CommunicationModel;
use App\Repository\ClassRepository;
use App\Repository\SubjectRepository;
use App\Repository\AdminRepository;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use App\Repository\SessionRepository;
use App\Repository\GradeSettingsRepository;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminService
{
    // SIGNIN
    public function signIn(Request $request)
    {
        $admin = AdminModel::where('username', $request->id)->get()->first();
        if ($admin == null) {
            return  response(['success' => false, 'message' => "Invalid Admin!"]);
        } else {

            if ($admin->password == $request->password) {
                $token = $admin->createToken('token')->plainTextToken;
                $station = [];
                if ($admin->role == "SUPERADMIN") {
                    $station = AdminModel::where("role", "ADMIN")->whereNotNull('terminal_id')->get();
                } else {
                    $station = AdminModel::where('id',$admin->id)->get();
                }

                return  response(['token' => $token, 'success' => true, 'message' => 'Welcome, Admin', 'data' => $admin, 'station' => $station]);
            } else {
                return  response(['success' => false, 'message' => "Invalid Password"]);
            }
        }
    }
}
