<?php

namespace App\Repository;

use App\Model\GradeSettingsModel;
use App\Service\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradeSettingsRepository
{
    public function createGrade(Request $request)
    {
        $GradeSettingsModel = new GradeSettingsModel();
        $GradeSettingsModel->min =  $request->min;
        $GradeSettingsModel->max =  $request->max;
        $GradeSettingsModel->grade =  $request->grade;
        $GradeSettingsModel->remark =  $request->remark;
        $GradeSettingsModel->save();

        return response()->json(['success' => true, 'message' => 'Grade was created successfully.']);
    }

    public function editGrade(Request $request)
    {
        $GradeSettingsModel = GradeSettingsModel::find($request->grade_id);
        $GradeSettingsModel->min =  $request->min;
        $GradeSettingsModel->max =  $request->max;
        $GradeSettingsModel->grade =  $request->grade;
        $GradeSettingsModel->remark =  $request->remark;
        $GradeSettingsModel->save();

        return response()->json(['success' => true, 'message' => 'Grade updated successfully.']);
    }

    public function deleteGrade($grade_id)
    {
        GradeSettingsModel::find($grade_id)->delete();
        return response()->json(['success' => true, 'message' => 'Grade was deleted successfully.']);
   
    }

    public function getGradeAndRemark($score)
    {
        // $score = (int) $score;
        // return  GradeSettingsModel::select('grade', 'remark')->where([
        //     [$score, '>=', 'min'], [$score, '<=', 'max']
        // ])->get()->first();
        return DB::select('select grade, remark from grade_settings where :score between min and max', ['score' => $score]);
    }
}
