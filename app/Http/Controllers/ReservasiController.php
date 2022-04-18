<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Mail\PaymentApproveMail;
use App\Mail\PaymentRejectMail;
use App\Models\Laporan;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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

    public function laporan()
    {
        $data = Laporan::all();
        return view('admin.laporan.index', compact('data'));
    }

    public function postLaporan(Request $request)
    {
        try {
            $cek = Laporan::where('bulan', $request->tanggal . '-01')->first();
            if($cek) {
                return response()->json('Ada');
            }
            $bulan = explode('-', $request->tanggal)[1];
            $tahun = explode('-', $request->tanggal)[0];
            Excel::store(new LaporanExport($bulan, $tahun), 'laporan' . $request->tanggal . '.xlsx', 'public');
            Laporan::create([
                'name' => 'laporan' . $request->tanggal . '.xlsx',
                'bulan' => $request->tanggal . '-01',
            ]);
            return response()->json('Success');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function deleteLaporan($id)
    {
        try {
            $data = Laporan::find($id);
            Storage::disk('public')->delete($data->name);
            $data->delete();
            return response()->json('Sukses');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
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

    public function xenditInvoiceCallback(Request $request)
    {
        $callbackToken = $request->header('x-callback-token');
        if($callbackToken == env('XENDIT_CALLBACK_TOKEN')){
            $responseArray = $request->json()->all();
            $data = Reservasi::where('inv', $responseArray['external_id'])
                ->first();
            if($data){
                Mail::to($data->email)->send(new PaymentApproveMail($data));
                
                $data->is_approve = 1;
                $data->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Sucess',
                    'data' => $data
                ]);            
            }else{
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invoice Not Found',
                ]);            
            }
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Wrong callback token'
            ]);
        }
    }
}
