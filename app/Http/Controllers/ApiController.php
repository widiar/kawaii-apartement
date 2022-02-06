<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Room;
use DateTime;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function checkRoom(Request $request)
    {
        $id = $request->room;
        $cek = Room::find($id);
        if($cek->checkSisa($request->checkin) > 0){
            return [
                'status' => 200,
                'message' => 'Room avaliable',
                'data' => $cek->checkSisa($request->checkin)
            ];
        }else {
            return [
                'status' => 203,
                'message' => 'Room not avaliable',
                'data' => $cek->checkSisa($request->checkin)
            ];
        }
    }
}
