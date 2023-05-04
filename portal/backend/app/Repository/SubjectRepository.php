<?php

namespace App\Repository;

use App\Model\ClassModel;
use App\Model\SessionModel;
use App\Model\SubjectModel;
use App\Model\SubjectRegistrationModel;
use App\Service\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubjectRepository
{

    public function createSubject(SubjectModel $SubjectModel)
    {
        if (SubjectModel::where('subject_name', $SubjectModel->subject_name)->where('class', $SubjectModel->class)->exists()) {
            return response()->json(['success' => false, 'message' => 'This subject already exist']);
        }

        $SubjectModel->save();
        $AdminService = new AdminService();
        //CREATE LESSON PLAN
        $AdminService->createlessonPlan($SubjectModel->id);
        return response()->json(['success' => true, 'message' => 'Subject was created successfully.']);
    }

    public function multiCreateSubject(Request $request)
    {
        $count = 0;
        $class_sector = $request->class_id;

        if ($class_sector == "ALL") {
            // CREATE FPR ALL CLASS
            $classes =  ClassModel::select('id')->get();
            if (count($classes) < 1) {
                return response()->json(['success' => false, 'message' => 'No class available for subject creation.']);
            }

            foreach ($classes as $class) {

                $SubjectModel = new SubjectModel();
                $SubjectModel->subject_name =  $request->subject_name;
                $SubjectModel->teacher =  $request->teacher;
                $SubjectModel->class =  $request->class_id;
                $SubjectModel->class = $class->id;

                if (SubjectModel::where('subject_name', $SubjectModel->subject_name)->where('class', $class_sector)->exists()) {
                    continue;
                }

                $SubjectModel->save();
                $AdminService = new AdminService();
                //CREATE LESSON PLAN
                $AdminService->createlessonPlan($SubjectModel->id);

                $count = $count + 1;
            }
        } else if ($class_sector == "NURSERY SCHOOL" || $class_sector == "PRIMARY SCHOOL" || $class_sector == "JUNIOR SECONDARY SCHOOL" || $class_sector == "SENIOR SECONDARY SCHOOL") {

            // DO MULTIPLE CREATION
            $classes =  ClassModel::select('id')->where('class_sector', $class_sector)->get();
            if (count($classes) < 1) {
                return response()->json(['success' => false, 'message' => 'No class available for subject creation.']);
            }

            foreach ($classes as $class) {
                $SubjectModel = new SubjectModel();
                $SubjectModel->subject_name =  $request->subject_name;
                $SubjectModel->teacher =  $request->teacher;
                $SubjectModel->class =  $request->class_id;

                $SubjectModel->class = $class->id;
                if (SubjectModel::where('subject_name', $SubjectModel->subject_name)->where('class', $SubjectModel->class)->exists()) {
                    continue;
                }

                $SubjectModel->save();
                $AdminService = new AdminService();
                //CREATE LESSON PLAN
                $AdminService->createlessonPlan($SubjectModel->id);

                $count = $count + 1;
            }
        }

        return response()->json(['success' => true, 'message' => 'Subject was created for ' . $count . ' class(es)']);
    }

    public function getAllSubject()
    {
        $Subjects =  SubjectModel::with('teacher', 'class')->orderBy('id', 'DESC')->get();

        foreach ($Subjects as $subject) {
            $student_no = $this->getNoSubjectRegistration($subject->id);
            $subject['student_no'] = $student_no;
        }
        return  $Subjects;
    }


    public function getNoSubjectRegistration($subject_id)
    {
        $session_term = SessionModel::where("session_status", "CURRENT")->get();
        if (count($session_term) == 0) {
            return 0;
        } else {
            return  SubjectRegistrationModel::where('subject_id', $subject_id)->where('session', $session_term[0]->session)->where('term', $session_term[0]->term)->count();
        }
    }

    public function editSubject(Request $request)
    {
        $SubjectModel = SubjectModel::find($request->subject_id);
        $SubjectModel->subject_name =  $request->subject_name;
       // $SubjectModel->class =  $request->class_id;
         $SubjectModel->class =  $request->class_id == "-" ?  $SubjectModel->class : $request->class_id;
        $SubjectModel->teacher =  $request->teacher;
        $SubjectModel->save();
        return response()->json(['success' => true, 'message' => 'Subject updated successfully.']);
    }

    public function deleteSubject($subject_id)
    {
        $SubjectModel = SubjectModel::find($subject_id);
        $SubjectModel->delete();
        return response()->json(['success' => true, 'message' => 'Subject was deleted successfully.']);
    }

    public function searchSubject($subject_name)
    {
        //     ->orWhere('name', 'like', '%' . Input::get('name') . '%')->get();
        return  SubjectModel::where('subject_name', 'like', '%' . $subject_name . '%')->with("teacher", "class")->get();
    }

    public function getNoOfAssignedSubject($teacher_id)
    {
        return DB::select('select count(teacher) as no_subject from subject where teacher =' . $teacher_id)[0]->no_subject;
    }
}
