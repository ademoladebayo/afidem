<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\LoanService;

class LoanController extends Controller
{

    public function createLoan(Request $request)
    {
        $LoanService = new LoanService();
        return $LoanService->createLoan($request);
    }

    public function updateLoan(Request $request)
    {
        $LoanService = new LoanService();
        return $LoanService->updateLoan($request);
    }

    public function fetchLoan($from, $to, $user_id, $type)
    {
        $LoanService = new LoanService();
        return $LoanService->fetchLoan($from, $to, $user_id, $type);
    }


}
