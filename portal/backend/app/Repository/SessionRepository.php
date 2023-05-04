<?php

namespace App\Repository;

use App\Model\PortalSubscription;
use App\Model\SessionModel;
use App\Service\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SessionRepository
{
    public function createSession(Request $request)
    {

        if (SessionModel::where('session', $request->session)->exists()) {
            return response()->json(['success' => false, 'message' => 'This session already exist']);
        }

        $PrevSessionModel = SessionModel::where('session_status', 'CURRENT')->first();
        Log::debug($PrevSessionModel);
        if ($PrevSessionModel != "") {
            $PrevSessionModel->session_status = "PAST";
            $PrevSessionModel->save();
        }

        $SessionModel = new SessionModel();
        $SessionModel->session =  $request->session;
        $SessionModel->term =  $request->term;
        $SessionModel->session_status = "CURRENT";
        $SessionModel->save();

        // CREATE A SUBSCRIPTION ID FOR THIS SESSION-TERM
        if (!PortalSubscription::where('subscription_id', 'LIKE', '%' . str_replace("/", "", $request->session) . '' . str_replace(" ", "", $request->term) . '%')->exists()) {
            $portalSubcription = new PortalSubscription();
            $portalSubcription->subscription_id = str_replace("/", "", $request->session) . "" . str_replace(" ", "", $request->term);
            $portalSubcription->description = '';
            $portalSubcription->status = 'NOT PAID';
            $portalSubcription->amount = 0;

            // UPDATE USAGE OF PAST OF PREVIOUS SESSION TERM
            if (count(PortalSubscription::orderBy("id", "DESC")->get()) > 0) {
                $subscription_fee = DB::table('school_details')->get()[0]->subscription_fee;
                $StudentRepository = new StudentRepository();
                $student = $StudentRepository->allStudentCount();
                $previousPortalSubcription = PortalSubscription::orderBy("id", "DESC")->get()[0];
                $previousPortalSubcription->description = "USAGE CHARGE FOR " . $student . " STUDENTS";
                $previousPortalSubcription->amount = $student * intval($subscription_fee);
                $previousPortalSubcription->save();
            }
            $portalSubcription->save();
        }


        return response()->json(['success' => true, 'message' => 'Session was created successfully.']);
    }

    public function editSession(Request $request)
    {
        $SessionModel = SessionModel::find($request->session_id);
        $SessionModel->session =  $request->session;
        $SessionModel->term =  $request->term;
        $SessionModel->save();

        // CREATE A SUBSCRIPTION ID FOR THIS SESSION-TERM
        if (!PortalSubscription::where('subscription_id', 'LIKE', '%' . str_replace("/", "", $request->session) . '' . str_replace(" ", "", $request->term) . '%')->exists()) {
            $portalSubcription = new PortalSubscription();
            $portalSubcription->subscription_id = str_replace("/", "", $request->session) . "" . str_replace(" ", "", $request->term);
            $portalSubcription->description = '';
            $portalSubcription->status = 'NOT PAID';
            $portalSubcription->amount = 0;

            // UPDATE USAGE OF PAST OF PREVIOUS SESSION TERM
            if (count(PortalSubscription::orderBy("id", "DESC")->get()) > 0) {
                $subscription_fee = DB::table('school_details')->get()[0]->subscription_fee;
                $StudentRepository = new StudentRepository();
                $student = $StudentRepository->allStudentCount();
                $previousPortalSubcription = PortalSubscription::orderBy("id", "DESC")->get()[0];
                $previousPortalSubcription->description = "USAGE CHARGE FOR " . $student . " STUDENTS";
                $previousPortalSubcription->amount = $student * intval($subscription_fee);
                $previousPortalSubcription->save();
            }
            $portalSubcription->save();
        }

        return response()->json(['success' => true, 'message' => 'Session updated successfully.']);
    }

    public function getCurrentSession()
    {
        if (count(SessionModel::where("session_status", "CURRENT")->get()) == 0) {
            return response()->json(['success' => false, 'message' => 'Welcome Admin, Please set you session first.']);
        } else {
            return response()->json(['success' => true, 'session' => SessionModel::where("session_status", "CURRENT")->get()[0]]);
        }
    }
}
