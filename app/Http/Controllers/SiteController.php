<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Reservasi;
use App\Models\Room;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $banner = Banner::all();
        $rooms = Room::with('image')->get();
        return view('index', compact('banner', 'rooms'));
    }

    public function roomDetail(Request $request, $id)
    {
        $room = Room::with('image')->find($id);
        return view('site.room', compact('room'));
    }

    public function reservasi(Request $request, $id)
    {
        try {
            $room = Room::find($id);
            $totalHarga = $room->harga * $request->jumlahhari;
            $bukti = $request->bukti;
            $data = Reservasi::create([
                'inv' => strtoupper(uniqid('INV/')),
                'nama' => $request->nama,
                'nik' => $request->nik,
                'email' => $request->email,
                'no_telepon' => $request->tlp,
                'room_id' => $id,
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'total_harga' => $totalHarga,
                'hari' => $request->jumlahhari,
                'bukti_bayar' => $bukti->hashName(),
            ]);
            $bukti->storeAs('public/bukti_bayar', $bukti->hashName());
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Throwable $th) {
            $data->delete();
            return response()->json($th->getMessage(), 500);
        }
    }
    

    public function invoiceMail(Request $request)
    {
        $inv = Reservasi::where('inv', urldecode($request->nomor))->where('is_approve', 1)->firstOrFail();
        $inv->load('room');
        return view('invoice-detail', compact('inv'));
    }
}
