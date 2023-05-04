<?php

namespace App\Http\Controllers;
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


}
