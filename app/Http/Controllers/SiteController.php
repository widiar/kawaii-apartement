<?php

namespace App\Http\Controllers;

use App\Mail\PaymentApproveMail;
use App\Models\Banner;
use App\Models\Reservasi;
use App\Models\Room;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Xendit\Invoice as XenditInvoice;
use Xendit\Xendit;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        if(isset($request->callback)){
            $invnumber = Crypt::decryptString($request->callback);
            $data = Reservasi::where('id', $invnumber)->first();
            $request->session()->flash('callback-success', 'Pembayaran Berhasil');
            if($data){
                //kirim email dll
                if(env('APP_ENV') == 'local') {
                    Mail::to($data->email)->send(new PaymentApproveMail($data));
                    
                    $data->is_approve = 1;
                    $data->save();
                }
                $request->session()->flash('callback-success', 'Pembayaran Berhasil');
            }
        } else{
            $request->session()->forget('callback-success');
        }
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
            $cek = $room;
            if($cek->checkSisa($request->checkin) <= 0){
                return [
                    'status' => 203,
                    'message' => 'Room not avaliable',
                    'data' => $cek->checkSisa($request->checkin)
                ];
            }
            $totalHarga = $room->harga * $request->jumlahhari;
            $voucher = NULL;
            if($request->voucher) {
                $voucher = Voucher::where('code', $request->voucher)->first()->id;
            }
            $data = Reservasi::create([
                'inv' => strtoupper(uniqid('INV/')),
                'nama' => $request->nama,
                'nik' => $request->nik,
                'email' => $request->email,
                'no_telepon' => $request->tlp,
                'room_id' => $id,
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'harga' => $room->harga,
                'total_harga' => $request->totalHarga,
                'hari' => $request->jumlahhari,
                'voucher_id' => $voucher,
                'bukti_bayar' => 'xendit',
            ]);
            Xendit::setApiKey(env('XENDIT_SECRET_KEY'));
            $params = [
                'external_id' => $data->inv,
                'amount' => $data->total_harga,
                'customer' => [
                    'given_names' => $data->nama,
                    'email' => $data->email
                ],
                'payer_email' => $data->email,
                'success_redirect_url' => route('home', ['language' => App::getLocale(),'callback' => Crypt::encryptString($data->id)]),
                'currency' => 'IDR'
            ];
            $xenInv = XenditInvoice::create($params);
            return response()->json([
                'status' => 200,
                'data' => $xenInv
            ]);
        } catch (\Throwable $th) {
            // $data->delete();
            return response()->json($th->getMessage(), 500);
        }
    }
    

    public function invoiceMail(Request $request)
    {
        $inv = Reservasi::with('promo')->where('inv', urldecode($request->nomor))->where('is_approve', 1)->firstOrFail();
        $inv->load('room');
        $diskon = 0;
        $code = NULL;
        if($inv->voucher_id) {
            if($inv->promo->type == 'percentage'){
                $diskon = ($inv->harga * $inv->hari) * ($inv->promo->value / 100);
            } else{
                $diskon = $inv->promo->value;
            }
            $code = $inv->promo->code;
        }
        return view('invoice-detail', compact('inv', 'diskon', 'code'));
    }

    public function checkVoucher(Request $request)
    {
        try {
            $voucher = Voucher::with(['used' => function ($q){
                $q->where('is_approve', 1);
            }])->where('code', $request->voucher)->first();
            if($voucher){
                if($voucher->status == 1){
                    if($voucher->used->count() < $voucher->max_use){
                        if($voucher->start_date <= date('Y-m-d') && $voucher->end_date >= date('Y-m-d')){
                            $data = [
                                'type' => $voucher->type,
                                'value' => $voucher->value,
                            ];
                            return response()->json([
                                'status' => 'success',
                                'message' => 'Voucher applied',
                                'voucher' => $data
                            ]);
                        } else {
                            return response()->json([
                                'status' => 'date',
                                'message' => 'Voucher date expired'
                            ]);
                        }
                    } else {
                        return response()->json([
                            'status' => 'max',
                            'message' => 'Voucher max use'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 'invalid',
                        'message' => 'Voucher invalid'
                    ]);
                }
            }else {
                return response()->json([
                    'status' => 'voucher',
                    'message' => 'Voucher not found'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
