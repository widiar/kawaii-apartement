@extends('template.master')

@section('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<style>
    .img-crop {
        height: 440px !important;
        width: 100%;
        object-fit: cover;
        object-position: center;
        filter: brightness(70%);
    }
    .btn {
        font-size: 17px;
        background: #FF8FAB;
        color: #fff;
        border: 2px solid #FF8FAB;
    }
</style>
@endsection

@section('main-content')
<div id="image-carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach ($room->image as $foto)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
            <img class="d-block img-crop w-100" src="{{Storage::url('rooms/image/') . $foto->image}}">
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#image-carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#image-carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

@php
$lang = app()->getLocale();
@endphp
<div id="fh5co-hotel-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="{{Storage::url('rooms/image/') . $room->image[0]->image}}" alt="" class="img-thumbnail w-100" style="height: 250px;object-fit: cover;object-position: center;">
            </div>
            <div class="col-md-8">
                <h1>{{ $room->jenis }}</h1>
                <div class="fasilitas mt-3">
                    <h2>Fasilitas</h2>
                    <ul>
                        @foreach (explode("|", json_decode($room->fasilitas)->$lang) as $fs)
                            <li>{{ $fs }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="price mt-4">
                    <h2>Harga Rp 500.000</h2>
                </div>
                <button class="mt-4 btn btn-primary btn-block">Pesan Sekarang</button>
            </div>
        </div>
    </div>
</div>

@endsection