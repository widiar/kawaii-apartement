<?php

namespace App\Http\Controllers;

use App\Models\Banner;
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
}
