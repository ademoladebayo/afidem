<?php

namespace App\Repository;

use App\Model\StudentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentRepository
{

    public function createStudent(StudentModel $studentModel)
    {
        if (StudentModel::where('first_name', $studentModel->first_name)->where('middle_name', $studentModel->middle_name)->where('last_name', $studentModel->last_name)->exists()) {
            return response()->json(['success' => false, 'message' => 'This student already exist']);
        }

        $studentModel->profile_status = 'ENABLED';
        // hash::make(strtolower($studentModel->last_name));
        $studentModel->password = env("DEFAULT_PASSWORD");

        $last_student_id = StudentModel::orderBy('id', 'DESC')->get();

        if (count($last_student_id) > 0) {  // IF ATLEAST A STUDENT HAS BEEN CREATED
            // THE IS A PREVIOUS STUDENT
            $last_student_id = $last_student_id[0]->student_id;
            $year = intval(explode("-", $last_student_id)[0]);
            $number = intval(explode("-", $last_student_id)[2]);
            $current_year = intval(date("Y"));

            if ($current_year > $year) {
                $studentModel->student_id = date("Y") . "-STD-" . "001";
            } else {
                $new_number = $number + 1;
                if (strlen($new_number) == 1) {
                    $studentModel->student_id = date("Y") . "-STD-00" . $new_number;
                } elseif (strlen($new_number) == 2) {
                    $studentModel->student_id = date("Y") . "-STD-0" . $new_number;
                } else {
                    $studentModel->student_id = date("Y") . "-STD-" . $new_number;
                }
            }
        } else {
            $studentModel->student_id = date("Y") . "-STD-" . "001";
        }

        $student_id =  $studentModel->student_id;
        $studentModel->save();
        return response()->json(['success' => true, 'student_id' => $student_id, 'message' => 'Student was created successfully.']);
    }
    public function getAllStudent()
    {
        $StudentModel =  new StudentModel();
        return  $StudentModel->with('class')->orderBy('id', 'DESC')->get();
    }
    public function updateStudentClass($student_id, $class_id)
    {
        $StudentModel = StudentModel::find($student_id);
        $StudentModel->assigned_class = $class_id;
        $StudentModel->save();
    }
    public function removeClassFromStudent($class_id)
    {
        $StudentModel =  StudentModel::where('assigned_class', $class_id)->first();
        if ($StudentModel != "") {
            log::debug($StudentModel);
            $StudentModel->assigned_class = "";
            $StudentModel->save();
        }
    }

    public function editStudent(Request $request)
    {
        $studentModel = StudentModel::find($request->student_id);
        $studentModel->first_name =  $request->first_name;
        $studentModel->last_name =  $request->last_name;
        $studentModel->middle_name =  $request->middle_name;
        $studentModel->gender =  $request->gender;
        $studentModel->dob =  $request->dob;
        $studentModel->religion =  $request->religion;
        $studentModel->state =  $request->state;
        $studentModel->home_address =  $request->home_address;
        $studentModel->joining_date =  $request->joining_date;
        $studentModel->class =  $request->student_class;


        $studentModel->guardian_name =  $request->guardian_name;
        $studentModel->guardian_phone =  $request->guardian_phone;
        $studentModel->guardian_email =  $request->guardian_email;
        $studentModel->guardian_address =  $request->guardian_address;


        $studentModel->save();

        return response()->json(['success' => true, 'message' => 'Student was updated successfully.']);
    }

    public function deleteStudent($student_id)
    {
        StudentModel::find($student_id)->delete();
        return response()->json(['success' => true, 'message' => 'Student was deleted successfully.']);
    }

    public function searchStudent($search_data)
    {
        return  StudentModel::where('student_id', 'like', '%' . $search_data . '%')->orWhere('first_name', 'like', '%' . $search_data . '%')->orWhere('last_name', 'like', '%' . $search_data . '%')->with("class")->get();
    }

    public function updateStudentProfileStatus($id)
    {
        $StudentModel =  StudentModel::find($id);
        $StudentModel->profile_status =  $StudentModel->profile_status == 'ENABLED' ? 'DISABLED' : 'ENABLED';
        $StudentModel->save();
        return response()->json(['success' => true, 'message' => 'Profile updated successfully.']);
    }

    public function updateStudentTranscriptAccess($id)
    {
        $StudentModel =  StudentModel::find($id);
        $StudentModel->can_access_transcript =  $StudentModel->can_access_transcript == 'YES' ? 'NO' : 'YES';
        $StudentModel->save();
        return response()->json(['success' => true, 'message' => 'Transcript access updated successfully.']);
    }

    public function getNoOfClassStudent($class_id)
    {
        $class_no =  DB::select('select count(class) as class_no from student where profile_status ="ENABLED" and  class =' . $class_id)[0]->class_no;
        $male = DB::select('select count(class) as male from student where profile_status = "ENABLED" and class =' . $class_id . ' and gender = "MALE"')[0]->male;
        $female =  DB::select('select count(class) as female from student where profile_status = "ENABLED" and class =' . $class_id . ' and gender = "FEMALE"')[0]->female;
        return [$class_no, $male, $female];
    }

    public function getPassword($id)
    {
        return DB::select("select password from student where student_id ='" . $id . "'")[0]->password;
    }

    public function allStudentCount()
    {
        return DB::select('select count(id) as student_no from student where profile_status = "ENABLED"')[0]->student_no;
    }

    public function updatePassword($student_id, $password)
    {
        DB::table('student')
            ->where('student_id', $student_id)
            ->update(['password' => $password]);
    }
}
