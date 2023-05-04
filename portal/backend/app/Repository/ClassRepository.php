<?php

namespace App\Repository;

use App\Model\ClassModel;
use App\Model\StudentModel;
use App\Service\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClassRepository
{
    public function createClass(ClassModel $ClassModel)
    {

        if (ClassModel::where('class_name', $ClassModel->class_name)->exists()) {
            return response()->json(['success' => false, 'message' => 'This class already exist']);
        }

        $AdminService = new AdminService();

        // UPDATE THE TEACHER ASSIGNED CLASS
        if ($ClassModel->class_teacher != "-") {
            $this->removeTeacherFromClass($ClassModel->class_teacher);
            $ClassModel->save();
            $AdminService->updateTeacherClass($ClassModel->class_teacher, $ClassModel->id);
        } else {
            $ClassModel->save();
        }
        return response()->json(['success' => true, 'message' => 'Class was created successfully.']);
    }

    public function editClass(Request $request)
    {
        $AdminService = new AdminService();

        $ClassModel = ClassModel::find($request->class_id);
        $ClassModel->class_name =  $request->class_name;
        $ClassModel->class_sector =  $request->class_sector;

        // REMOVE CLASS FROM PREVIOUS TEACHER
        // UPDATE THE TEACHER ASSIGNED CLASS
        if ($request->class_teacher !=  $ClassModel->class_teacher) {
            $AdminService->removeClassFromTeacher($request->class_id);
            $this->removeTeacherFromClass($ClassModel->class_teacher);
            $AdminService->updateTeacherClass($request->class_teacher, $request->class_id);
            $ClassModel->class_teacher =  $request->class_teacher;
        }
        $ClassModel->save();
        return response()->json(['success' => true, 'message' => 'Class updated successfully.']);
    }

    public function removeTeacherFromClass($teacher_id)
    {
        $ClassModel =  ClassModel::where('class_teacher', $teacher_id)->first();
        if ($ClassModel != "") {
            log::debug($ClassModel);
            $ClassModel->class_teacher = "-";
            $ClassModel->save();
        }
    }

    public function getAllClass()
    {
        $classes = ClassModel::with('class_teacher')->orderBy('id', 'DESC')->get();
        foreach ($classes as $class) {
            $student_no =  $this->getNumberOfStudent($class->id);
            $class['student_no'] = $student_no;
        }

        return $classes;
    }


    public function getNumberOfStudent($class_id)
    {
        return StudentModel::where('class', $class_id)->where("profile_status", "ENABLED")->count();
    }

    public function deleteClass($class_id)
    {
        $class = ClassModel::find($class_id);
        $class->delete();
        return response()->json(['success' => true, 'message' => 'Class was deleted successfully.']);
    }

    public function searchClass($class_name)
    {
        //     ->orWhere('name', 'like', '%' . Input::get('name') . '%')->get();
        return  ClassModel::where('class_name', 'like', '%' . $class_name . '%')->with("class_teacher")->get();
    }
}
