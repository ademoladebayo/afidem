<?php

namespace App\Repository;

use App\Model\TeacherModel;
use App\Model\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherRepository
{

    public function createTeacher(TeacherModel $TeacherModel)
    {

        if (TeacherModel::where('first_name', $TeacherModel->first_name)->where('middle_name', $TeacherModel->middle_name)->where('last_name', $TeacherModel->last_name)->exists()) {
            return response()->json(['success' => false, 'message' => 'This staff already exist']);
        }

        $TeacherModel->profile_status = 'ENABLED';
        $TeacherModel->password = Hash::make(strtolower($TeacherModel->first_name . "." . $TeacherModel->last_name));

        $last_teacher_id = TeacherModel::orderBy('id', 'DESC')->get();

        if (count($last_teacher_id) > 0) {
            // THE IS A PREVIOUS STAFF
            $last_teacher_id = $last_teacher_id[0]->teacher_id;
            $year = intval(explode("-", $last_teacher_id)[0]);
            $number = intval(explode("-", $last_teacher_id)[2]);
            $current_year = intval(date("Y"));

            if ($current_year > $year) {
                $TeacherModel->teacher_id = date("Y") . "-STF-" . "001";
            } else {
                $new_number = $number + 1;
                if (strlen($new_number) == 1) {
                    $TeacherModel->teacher_id = date("Y") . "-STF-00" . $new_number;
                } elseif (strlen($new_number) == 2) {
                    $TeacherModel->teacher_id = date("Y") . "-STF-0" . $new_number;
                } else {
                    $TeacherModel->teacher_id = date("Y") . "-STF-" . $new_number;
                }
            }
        } else {
            $TeacherModel->teacher_id = date("Y") . "-STF-" . "001";
        }

        $teacher_id =  $TeacherModel->teacher_id;
        $TeacherModel->save();
        return response()->json(['success' => true, 'message' => 'Staff ' . $teacher_id . ' was created successfully.']);
    }

    public function getAllTeacher()
    {
        $TeacherModel =  new TeacherModel();
        return  $TeacherModel->with('assigned_class')->orderBy('id', 'DESC')->get();
    }
    public function updateTeacherClass($teacher_id, $class_id)
    {
        $TeacherModel = TeacherModel::find($teacher_id);
        $TeacherModel->assigned_class = $class_id;
        $TeacherModel->save();
    }
    public function removeClassFromTeacher($class_id)
    {
        $TeacherModel =  TeacherModel::where('assigned_class', $class_id)->first();
        if ($TeacherModel != "") {
            log::debug($TeacherModel);
            $TeacherModel->assigned_class = "-";
            $TeacherModel->save();
        }
    }

    public function editTeacher(Request $request)
    {
        $TeacherModel = TeacherModel::find($request->teacher_id);
        $TeacherModel->title =  $request->title;
        $TeacherModel->first_name =  $request->first_name;
        $TeacherModel->last_name =  $request->last_name;
        $TeacherModel->middle_name = $request->middle_name == "" ? "" : $request->middle_name;
        $TeacherModel->gender =  $request->gender;
        $TeacherModel->phone =  $request->teacher_phone;
        $TeacherModel->email =  $request->teacher_email == "" ? "" : $request->teacher_email;
        $TeacherModel->dob =  $request->dob;
        $TeacherModel->religion =  $request->religion;
        $TeacherModel->joining_date =  $request->joining_date == "" ? "" : $request->joining_date;
        $TeacherModel->home_address =  $request->home_address;
        $TeacherModel->state =  $request->state;

        $TeacherModel->save();

        return response()->json(['success' => true, 'message' => 'Teacher was updated successfully.']);
    }

    public function deleteTeacher($teacher_id)
    {
        TeacherModel::find($teacher_id)->delete();
        return response()->json(['success' => true, 'message' => 'Teacher was deleted successfully.']);
    }

    public function searchTeacher($search_data)
    {
        return  TeacherModel::where('teacher_id', 'like', '%' . $search_data . '%')->orWhere('first_name', 'like', '%' . $search_data . '%')->orWhere('last_name', 'like', '%' . $search_data . '%')->with("assigned_class")->get();
    }

    public function updateTeacherProfileStatus($id)
    {
        $TeacherModel =  TeacherModel::find($id);
        $TeacherModel->profile_status =  $TeacherModel->profile_status == 'ENABLED' ? 'DISABLE' : 'ENABLED';
        $TeacherModel->save();
        return response()->json(['success' => true, 'message' => 'Profile updated successfully.']);
    }

    public function getPassword($id)
    {
        return DB::select("select password from teacher where teacher_id ='" . $id . "'")[0]->password;
    }

    public function updatePassword($teacher_id, $password)
    {
        DB::table('teacher')
            ->where('teacher_id', $teacher_id)
            ->update(['password' => $password]);
    }

    public function allTeacherCount()
    {
        return DB::select('select count(id) as teacher_no from teacher where profile_status = "ENABLED"')[0]->teacher_no;
    }
}
