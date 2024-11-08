<?php

namespace App\Http\Controllers;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Service\AdminService;

class AdminController extends Controller
{
    // SIGNIN
    public function signIn(Request $request)
    {
        $AdminService = new AdminService();
        return $AdminService->signIn($request);
    }


    public function createUser(Request $request)
    {
        if (UserModel::where(["first_name" => $request->first_name, "last_name" => $request->last_name, "phone" => $request->phone])->exists()) {
            return response(['success' => false, 'message' => "Customer already exists !"]);
        }

        $userModel = new UserModel();
        $userModel->first_name = strtoupper($request->first_name);
        $userModel->last_name = strtoupper($request->last_name);
        $userModel->phone = $request->phone;
        $userModel->address = strtoupper($request->address);
        $userModel->service = strtoupper($request->service);
        $userModel->status = "ACTIVE";
        $userModel->save();
        return response(['success' => true, 'message' => "Customer was successfully created."]);
    }

    public function updateUser(Request $request)
    {
        $userModel = UserModel::find($request->user_id);
        $userModel->first_name = strtoupper($request->first_name);
        $userModel->last_name = strtoupper($request->last_name);
        $userModel->phone = $request->phone;
        $userModel->address = strtoupper($request->address);
        $userModel->service = strtoupper($request->service);
        $userModel->status = strtoupper($request->status);
        $userModel->save();
        return response(['success' => true, 'message' => "Customer info was successfully updated."]);
    }

    public function getUsers($service = null)
    {
        if ($service) {
            return UserModel::select('id', 'first_name', 'last_name')->where('service', 'LIKE', '%' . $service . '%')->where("status", "ACTIVE")->get();
        } else {
            $data =
                [
                    "stat" => [
                        "all" => UserModel::where("status", "ACTIVE")->count(),
                        "ajo" => UserModel::where("status", "ACTIVE")->where('service', 'LIKE', '%AJO%')->count(),
                        "loan" => UserModel::where("status", "ACTIVE")->where('service', 'LIKE', '%LOAN%')->count(),
                        "service_room" => UserModel::where("status", "ACTIVE")->where('service', 'LIKE', '%SERVICE_ROOM%')->count()
                    ],
                    "customer" => UserModel::select("*")->orderBy("id", "DESC")->get()
                ];

            return $data;
        }

    }



}
