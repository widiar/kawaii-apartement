<?php

namespace App\Http\Controllers;

use App\Mail\PaymentApproveMail;
use App\Mail\PaymentRejectMail;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservasiController extends Controller
{
    public function  index()
    {
        $data = Reservasi::with('room')->orderBy('created_at', 'ASC')->get();
        return view('admin.reservasi.index', compact('data'));
    }

    public function updateStatus(Request $request)
    {
        try {
            $data = Reservasi::find($request->id);
            if($request->status == 1){
                $data->is_approve = 1;
                Mail::to($data->email)->send(new PaymentApproveMail($data));
            } else{
                $data->is_approve = 2;
                Mail::to($data->email)->send(new PaymentRejectMail($data));
            }
            $data->save();
            return response()->json('success');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function tamu()
    {
        $data = Reservasi::orderBy('created_at', 'ASC')->get();
        return view('admin.reservasi.tamu', compact('data'));
    }

    public function checkDetailHarga(Request $request)
    {
        try {
            $data = Reservasi::with('promo')->find($request->id);
            $diskon = 0;
            if($data->voucher_id) {
                if($data->promo->type == 'percentage'){
                    $diskon = ($data->harga * $data->hari) * ($data->promo->value / 100);
                } else{
                    $diskon = $data->promo->value;
                }
            }
            return response()->json([
                'status' => 'success',
                'harga' => $data->harga * $data->hari,
                'total_harga' => $data->total_harga,
                'diskon' => $diskon
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
