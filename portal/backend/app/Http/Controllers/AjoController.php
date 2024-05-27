<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\AjoService;
use App\Model\AjoModel;

class AjoController extends Controller
{

    public function createTransaction(Request $request)
    {
        $AjoService = new AjoService();
        return $AjoService->createTransaction($request);
    }

    public function fetchTransaction($from, $to, $user_id)
    {
        $AjoService = new AjoService();
        return $AjoService->fetchTransaction($from, $to, $user_id);
    }


}
