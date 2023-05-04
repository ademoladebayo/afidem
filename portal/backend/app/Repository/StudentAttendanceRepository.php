<?php

namespace App\Repository;

use Illuminate\Http\Request;
use App\Model\StudentAttendanceModel;
use App\Model\StudentModel;
use App\Service\AdminService;
use App\Service\BursaryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentAttendanceRepository
{

    public function takeAttendance(Request $request)
    {
        $StudentAttendanceModel = new StudentAttendanceModel();

        //   USING STUDENT NUMBER
        if ($request->class_id == "") {
            // CHECK IF STUDENT ID EXIST
            $student = StudentModel::where("student_id", $request->student_id)->get();
            if (count($student) != 0) {

                // CHECK IF ALREADY TAKEN 
                $request->student_id = $student[0]->id;
                $alreadytaken =  $this->takenAttendance($request);


                if ($alreadytaken) {
                    // CHECK OUT STUDENT
                    if ($request->check_out) {
                        $StudentAttendanceModel = StudentAttendanceModel::where('student_id', $student[0]->id)->where('date', $request->date)->get()[0];
                        $StudentAttendanceModel->time_out = $request->time;
                        $StudentAttendanceModel->save();
                        return response()->json(['success' => true, 'message' => 'Check out was succesful.']);
                    }
                }


                // CHECK CONTROL BEFORE TAKING ATTENDANCE (TIME AND % PAID CHECK)
                $AdminService = new AdminService();
                $BursaryService = new BursaryService();

                if (explode("-", $AdminService->isResumptionTimeCheckOpened())[0]) {
                    //  CHECK CLOCK IN TIME AGAINST THE ONE IN THE CONTROL
                    $time = intval(explode(":", $request->time)[0]);
                    $control_time = intval(explode("-", $AdminService->isResumptionTimeCheckOpened())[1]);
                    Log::alert("TIME IN : " . $time ." CONTROL TIME : ". $control_time);
                    if ($time > $control_time) {
                        return response(['success' => false, 'message' => "It is past resumption time, you are late !"]);
                    }
                }


                if (explode("-", $AdminService->isCheckDebitorsOpened())[0]) {
                    //  CHECK CLOCK IN TIME AGAINST THE ONE IN THE CONTROL
                    $paid_percentage = intval($BursaryService->getStudentPercentagePaid($request));
                    $control_percentage = intval(explode("-", $AdminService->isCheckDebitorsOpened())[1]);
                    if ($paid_percentage < $control_percentage) {
                        return response(['success' => false, 'message' => "Access denied ! you have only paid " . $paid_percentage . " out of " . $control_percentage . " percent required."]);
                    }
                }


                // GET CLASS
                $StudentAttendanceModel->student_id = $student[0]->id;
                $StudentAttendanceModel->class_id = $student[0]->class;
                $StudentAttendanceModel->date = $request->date;
                $StudentAttendanceModel->time_in = $request->time;
                $StudentAttendanceModel->session = $request->session;
                $StudentAttendanceModel->term = $request->term;
                $StudentAttendanceModel->save();
                return response()->json(['success' => true, 'message' => 'Attendance was successful.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid Student ID']);
            }
        }


        //   USING CARD
        // CHECK IF ALREADY TAKEN 
        $alreadytaken =  $this->takenAttendance($request);

        if ($alreadytaken) {
            // CHECK OUT STUDENT
            if ($request->check_out) {
                $StudentAttendanceModel = StudentAttendanceModel::where('student_id', $request->student_id)->where('date', $request->date)->get()[0];
                $StudentAttendanceModel->time_out = $request->time;
                $StudentAttendanceModel->save();
                return response()->json(['success' => true, 'message' => 'Check out was succesful.']);
            }
        }

        // CHECK CONTROL BEFORE TAKING ATTENDANCE (TIME AND % PAID CHECK)
        $AdminService = new AdminService();
        $BursaryService = new BursaryService();

        if (explode("-", $AdminService->isResumptionTimeCheckOpened())[0]) {
            //  CHECK CLOCK IN TIME AGAINST THE ONE IN THE CONTROL
            $time = intval(explode(":", $request->time)[0]);
            $control_time = intval(explode("-", $AdminService->isResumptionTimeCheckOpened())[1]);
            if ($time > $control_time) {
                return response(['success' => false, 'message' => "It is past resumption time, you are late !"]);
            }
        }


        if (explode("-", $AdminService->isCheckDebitorsOpened())[0]) {
            //  CHECK CLOCK IN TIME AGAINST THE ONE IN THE CONTROL
            $paid_percentage = intval($BursaryService->getStudentPercentagePaid($request));
            $control_percentage = intval(explode("-", $AdminService->isCheckDebitorsOpened())[1]);
            if ($paid_percentage < $control_percentage) {
                return response(['success' => false, 'message' => "Access denied ! you have only paid " . $paid_percentage . " out of " . $control_percentage . " percent required."]);
            }
        }


        $StudentAttendanceModel->student_id = $request->student_id;
        $StudentAttendanceModel->class_id = $request->class_id;
        $StudentAttendanceModel->date = $request->date;
        $StudentAttendanceModel->time_in = $request->time;
        $StudentAttendanceModel->session = $request->session;
        $StudentAttendanceModel->term = $request->term;
        $StudentAttendanceModel->save();
        return response()->json(['success' => true, 'message' => 'Attendance was successful.']);
    }

    public function getAttendance(Request $request)
    {

        $StudentAttendanceModel =  new StudentAttendanceModel();
        return  $StudentAttendanceModel->with('student', 'class')->where('date', $request->date)->get();
    }

    public function takenAttendance(Request $request)
    {
        // CHECK IF ALREADY TAKEN 
        return DB::table('student_attendance')->where("student_id", $request->student_id)->where('date', $request->date)->exists();
    }
}
