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

    public function getUsers($service)
    {
        return UserModel::select('id', 'first_name', 'last_name')->where('service', 'LIKE', '%' . $service . '%')->get();
    }



}
