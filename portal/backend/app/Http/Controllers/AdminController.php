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
        if (UserModel::where(["first_name" => $request->first_name, "last_name" => $request->last_name, "phone" => $request->phone])->exist()) {
            return response(['success' => false, 'message' => "Customer already exists !"]);
        }

        $userModel = new UserModel();
        $userModel->first_name = $request->first_name;
        $userModel->last_name = $request->last_name;
        $userModel->phone = $request->phone;
        $userModel->address = $request->address;
        $userModel->service = $request->service;
        $userModel->status = "ACTIVE";
        $userModel->save();
        return response(['success' => true, 'message' => "Customer was successfully created."]);
    }

    public function updateUser(Request $request)
    {
        $userModel = UserModel::find($request->user_id);
        $userModel->first_name = $request->first_name;
        $userModel->last_name = $request->last_name;
        $userModel->phone = $request->phone;
        $userModel->address = $request->address;
        $userModel->service = $request->service;
        $userModel->status = $request->status;
        $userModel->save();
        return response(['success' => true, 'message' => "Customer info was successfully updated."]);
    }

    public function getUsers($service = null)
    {
        if ($service) {
            return UserModel::select('id', 'first_name', 'last_name')->where('service', 'LIKE', '%' . $service . '%')->where("status", "ACTIVE")->get();
        } else {
            $customers = UserModel::select("*");

            $data =
                [
                    "stat" => [
                        "all" => clone $customers->where("status", "ACTIVE")->count(),
                        "ajo" => clone $customers->where("status", "ACTIVE")->where('service', 'LIKE', '%AJO%')->count(),
                        "loan" => clone $customers->where("status", "ACTIVE")->where('service', 'LIKE', '%LOAN%')->count(),
                        "service_room" => clone $customers->where('service', 'LIKE', '%SERVICE_ROOM%')->count()
                    ],
                    "customer" => clone $customers->get()
                ];

            return $data;
        }

    }



}
