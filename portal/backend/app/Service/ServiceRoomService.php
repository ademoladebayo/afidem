<?php

namespace App\Service;

use App\Http\Controllers\NotificationController;
use App\Model\RoomModel;
use App\Model\AdminModel;
use App\Util\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ServiceRoomService
{


    public function bookRoom(Request $request)
    {
        $RoomModel = new RoomModel();
        $RoomModel->user_id = $request->user_id;
        $RoomModel->room_no = $request->room;
        $RoomModel->amount = $request->amount;
        $RoomModel->checked_in = $request->checked_in;
        $RoomModel->checked_out = null;
        $RoomModel->duration = '-';
        $RoomModel->total_charge = 0;
        $RoomModel->save();


        $deviceTokens = AdminModel::select('device_token')
            ->where('role', 'SUPERADMIN')
            ->get();

        $receiver = [];

        foreach ($deviceTokens as $token) {
            $receiver[] = $token->device_token;
        }
        ;

        NotificationController::createNotification(Utils::getUserLoggedIn($request) . ' JUST BOOK A NEW ROOM AT ₦' . number_format($request->amount), $receiver);
        return response(['success' => true, 'message' => "Room booked successfully."]);
    }

    public function updateLoan(Request $request)
    {
        $RoomModel = RoomModel::find($request->id);
        $RoomModel->user_id = $request->user_id;
        $RoomModel->room_no = $request->room;
        $RoomModel->amount = $request->amount;
        $RoomModel->checked_in = $request->checked_in;
        $RoomModel->checked_out = $request->checked_out;
        $RoomModel->duration = $request->duration;
        $RoomModel->total_charge = $request->total_charge;
        $RoomModel->save();

        return response(['success' => true, 'message' => "Booked room was updated successfully."]);
    }


    public function getBookedRoom($from, $to, $user_id = null)
    {
        $month = explode("-", $from)[0] . "-" . explode("-", $from)[1];
        $start_date = $from . " 00:00:00";
        $end_date = $to . " 23:59:00";
        $user_id = $user_id == '0' ? null : $user_id;

        $bookedRoom = RoomModel::whereBetween('checked_in', [$start_date, $end_date]);
        $total_sales = $bookedRoom->sum('total_charge');
        $total_user = count($bookedRoom->distinct()->pluck('user_id')->toArray());


        $data =
            [
                'success' => true,
                'total_user' => $total_user,
                'total_sales' => $total_sales,
                'room' => $this->getAvailableRooms(),
                'data' => $bookedRoom->get()
            ];

        return response($data);
    }


    public function getAvailableRooms()
    {
        $rooms = [1, 2, 3, 4];
        $available_rooms = [];

        $available_room = 0;
        foreach ($rooms as $room) {
            if (!RoomModel::where('room_no', $room)->where('checked_out', null)->exists()) {
                array_push($available_rooms, $room);
                $available_room += 1;
            }
        }

        return
            [
                'stat' => $available_room . ' of ' . count($rooms),
                'available_rooms' => $available_rooms
            ];
    }

}
