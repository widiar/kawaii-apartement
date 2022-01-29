<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Banner::all();
        return view('admin.banner.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $foto = $request->foto;
        Banner::create([
            'title' => json_encode([
                'id' => $request->title_id,
                'en' => $request->title_en
            ]),
            'foto' => $foto->hashName(),
        ]);
        $foto->storeAs('public/banner', $foto->hashName());
        return redirect()->route('admin.banner.index')->with('success', 'Berhasil menambah data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Banner::find($id);
        return view('admin.banner.edit', compact('data'));
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
        $data = Banner::find($id);
        $data->title = json_encode([
            'id' => $request->title_id,
            'en' => $request->title_en
        ]);
        $foto = $request->file('foto');
        if ($foto) {
            Storage::disk('public')->delete('banner/' . $data->foto);
            $foto->storeAs('public/banner', $foto->hashName());
            $data->foto = $foto->hashName();
        }
        $data->save();
        return redirect()->route('admin.banner.index')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Banner::find($id);
        Storage::disk('public')->delete('banner/' . $data->foto);
        $data->delete();
        return response()->json("Sukses");
    }
}
