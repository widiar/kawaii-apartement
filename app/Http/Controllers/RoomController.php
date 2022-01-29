<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Room::all();
        return view('admin.room.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = Room::create([
                'jenis' => $request->jenis,
                'harga' => str_replace(',', '', $request->harga),
                'jumlah' => $request->jumlah,
                'fasilitas' => json_encode([
                    'id' => $request->fasilitas_id,
                    'en' => $request->fasilitas_en,
                ]),
            ]);
            //save foto
            foreach ($request->fotofile as $file) {
                $data->image()->create([
                    'image' => $file->hashName()
                ]);
                $file->storeAs('public/rooms/image', $file->hashName());
            }
            $request->session()->flash('success', 'Berhasil menambah data');
            return response()->json('Sukses');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Room::with('image')->findOrFail($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Room::with('image')->find($id);
        return view('admin.room.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Room::find($id);
            $data->jenis = $request->jenis;
            $data->harga = str_replace(',', '', $request->harga);
            $data->jumlah = $request->jumlah;
            $data->fasilitas = json_encode([
                'id' => $request->fasilitas_id,
                'en' => $request->fasilitas_en,
            ]);

            //save foto
            if(isset($request->fotofile)){
                foreach ($request->fotofile as $file) {
                    $data->image()->create([
                        'image' => $file->hashName()
                    ]);
                    $file->storeAs('public/rooms/image', $file->hashName());
                }
            }
            $data->save();
            $request->session()->flash('success', 'Berhasil update data');
            return response()->json('Sukses');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Room::find($id);
        $data->delete();
        return response()->json('Sukses');
    }

    public function deleteImage(Request $request)
    {
        $id = $request->id;
        $data = RoomImage::find($id);
        Storage::disk('public')->delete('rooms/image/' . $data->image);
        $data->delete();
        return response()->json('deleted');
    }
}
