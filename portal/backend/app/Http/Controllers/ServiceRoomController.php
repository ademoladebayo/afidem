<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\ServiceRoomService;
use App\Model\RoomModel;

class ServiceRoomController extends Controller
{

    public function bookRoom(Request $request)
    {
        $ServiceRoomService = new ServiceRoomService();
        return $ServiceRoomService->bookRoom($request);
    }

    public function updateBookedRoom(Request $request)
    {
        $ServiceRoomService = new ServiceRoomService();
        return $ServiceRoomService->updateBookedRoom($request);
    }


    public function getBookedRooms($from, $to)
    {
        $ServiceRoomService = new ServiceRoomService();
        return $ServiceRoomService->getBookedRoom($from, $to);
    }


}
