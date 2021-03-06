<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Voucher::with(['used' => function ($q){
            $q->where('is_approve', 1);
        }])->orderBy('created_at', 'DESC')->get();
        return view('admin.voucher.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function generateCode()
    {
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; //abcdefghijklmnopqrstuvwxyz
        $result = substr(str_shuffle($string), 0, 10);
        $ref = Voucher::where('code', $result)->first();
        if($ref){
            return $this->generateCode();
        }
        return $result;
    }

    public function generate()
    {
        $code = $this->generateCode();
        return response()->json(['code' => $code]);
    }

    public function create()
    {
        $code = $this->generateCode();
        return view('admin.voucher.create', compact('code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code',
            'name' => 'required',
            'type' => 'required',
            'value' => 'required',
            'max' => 'required',
            'start' => 'required',
            'end' => 'required',
            'status' => 'required',
        ]);
        Voucher::create([
            'name' => $request->name,
            'type' => $request->type,
            'code' => $request->code,
            'value' => $request->value,
            'max_use' => $request->max,
            'start_date' => $request->start,
            'end_date' => $request->end,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.voucher.index')->with('success', 'Voucher created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $voucher)
    {
        $data = $voucher;
        return view('admin.voucher.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code,'.$voucher->id,
            'name' => 'required',
            'type' => 'required',
            'value' => 'required',
            'max' => 'required',
            'start' => 'required',
            'end' => 'required',
            'status' => 'required',
        ]);
        $voucher->update([
            'name' => $request->name,
            'type' => $request->type,
            'code' => $request->code,
            'value' => $request->value,
            'max_use' => $request->max,
            'start_date' => $request->start,
            'end_date' => $request->end,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.voucher.index')->with('success', 'Voucher updated successfully');
    }

    public function changeStatus(Request $request, $id)
    {
        $voucher = Voucher::find($id);
        $status = $voucher->status == 1 ? 0 : 1;
        $voucher->update([
            'status' => $status,
        ]);
        return response()->json('Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return response()->json('Sukses');
    }
}
