@extends('template.master')

@section('css')
<style>
    .img-crop {
        height: 440px !important;
        width: 100%;
        object-fit: cover;
        object-position: center;
        filter: brightness(70%);
    }
    .btn{
        font-size: 17px;
    }
    .btn-pink {
        background: #FF8FAB;
        color: #fff;
        border: 2px solid #FF8FAB;
    }
    .bank-container {
		display: flex;
		justify-content: space-evenly;
		align-items: center;
	}

	.bank-img img {
		object-fit: contain;
		object-position: center;
		width: 200px;
	}

	.img-detail {
		object-fit: cover;
		object-position: center;
		width: 100%;
		cursor: pointer;
		height: 200px;
	}

	@media screen and (max-width: 768px) {
		.img-info {
			display: none;
		}

		.total-amount {
			font-size: 26px;
		}

		.bank-img {
			margin: 0 20px;
		}

		.bank-img img {
			width: 100px;
		}
	}



    .slideshow-container {
        width: 100%;
        position: relative;
        margin: auto;
    }

    /* Hide the images by default */
    .mySlides {
        display: none;
    }

    /* Next & previous buttons */
    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        margin-top: -22px;
        padding: 16px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {
        background-color: rgba(0,0,0,0.8);
    }

    /* Fading animation */
    .faded {
        -webkit-animation-name: fade;
        -webkit-animation-duration: 1.5s;
        animation-name: fade;
        animation-duration: 1.5s;
    }

    @-webkit-keyframes faded {
        from {opacity: .4}
        to {opacity: 1}
    }

    @keyframes faded {
        from {opacity: .4}
        to {opacity: 1}
    }
</style>
@endsection

@section('main-content')
<div class="slideshow-container">

    <!-- Full-width images with number and caption text -->
    @foreach ($room->image as $item)
        <div class="mySlides faded">
            <img src="{{Storage::url('rooms/image/') . $item->image}}" class="img-crop">
        </div>
    @endforeach
  
    <!-- Next and previous buttons -->
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>

@php
$lang = app()->getLocale();
@endphp
<div id="fh5co-hotel-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @foreach ($room->image as $item)
                <a class="venobox" data-gall="roomPhotos" href="{{Storage::url('rooms/image/') . $item->image}}" style="display: {{ ($loop->first) ? '' : 'none' }}">
                    <img src="{{Storage::url('rooms/image/') . $item->image}}" alt="" class="img-thumbnail w-100" style="height: 250px;object-fit: cover;object-position: center;">
                </a>
                @endforeach
            </div>
            <div class="col-md-8">
                <h1>{{ $room->jenis }}</h1>
                <div class="fasilitas">
                    <h2 style="margin: 0">Fasilitas</h2>
                    <ul>
                        @foreach (explode("|", json_decode($room->fasilitas)->$lang) as $fs)
                            <li>{{ $fs }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="price">
                    <h2>Harga Rp 500.000</h2>
                </div>
                <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#bayarModal">Pesan Sekarang</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bayarModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="pembayaranModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="pembayaranModal">Detail</h3>
            </div>
            <form action="#" method="POST" id="form-reservasi">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Tanggal Chekin</label>
                        <input name="tanggal" id="tanggal" required type="text" class="form-control"
                            value="{{ @$carts[0]->tanggal }}">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Checkout</label>
                        <input name="jam" id="jam" required type="text" class="form-control timepicker"
                            value="{{ @$carts[0]->jam }}">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" required class="form-control" name="nama"
                            placeholder="Masukkan Nama Lengkap" value="{{ @$user->nama }}">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" required class="form-control" name="alamat" placeholder="Masukkan Alamat"
                            value="{{ @$user->alamat }}">
                    </div>
                    <div class="form-group">
                        <label for="tlp">No. Telepon</label>
                        <input type="text" required class="form-control" name="tlp"
                            placeholder="Masukkan No. Telepon" value="{{ @$user->no_tlp }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="transaksiModal" data-backdrop="static" role="dialog" aria-labelledby="pembayaranModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="pembayaranModal">Pembayaran</h3>
            </div>
            <form action="#" method="POST" id="form-pembayaran"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h3 class="text-center">Silahkan Transfer ke Bank BCA</h3>
                    <h3 class="text-center">Total Rp <span class="bayar"></span></h3>
                    <div class="bank-container">
                        <div class="bank-img">
                            <img src="https://www.freepnglogos.com/uploads/logo-bca-png/bank-central-asia-logo-bank-central-asia-bca-format-cdr-png-gudril-1.png"
                                alt="">
                        </div>
                        <div class="bank-text">
                            <h3>a.n. Edward</h3>
                            <h4>7720578128</h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bukti">Upload Bukti Pembayaran</label>
                        <div class="custom-file">
                            <input type="file" required name="bukti"
                                class="file custom-file-input @error('bukti') is-invalid @enderror" id="bukti"
                                value="{{ old('bukti') }}" accept="image/x-png, image/jpeg">
                            <label class="custom-file-label" for="bukti">
                                <span class="d-inline-block text-truncate w-75">Browse File</span>
                            </label>
                            @error("bukti")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">upload format file .png, .jpg max 5mb.</small>
                    </div>
                    <img src="https://via.placeholder.com/1080x1080.png?text=BuktiBayar" alt=""
                        class="img-thumbnail img-detail">
                    <small>Klik Gambar Untuk Lihat Detail</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" role="dialog" aria-labelledby="pembayaranModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="pembayaranModal">Bukti Bayar</h3>
            </div>
            <div class="modal-body">
                <img src="" alt="" class="img-thumbnail img-modal-detail" style="width: 100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>

    $('body').on('hidden.bs.modal', function () {
        if($('.modal.in').length > 0)
        {
            $('body').addClass('modal-open');
        }
    });

    $(document).ready(function(){
        new VenoBox();
        $('#form-reservasi').submit(function(e){
            e.preventDefault()
            $('#bayarModal').modal('hide')
            $('#transaksiModal').modal('show')
        })
        $('#bukti').change(function(e){
			let url = URL.createObjectURL(e.target.files[0])
			$(".img-detail").attr("src", url)
		})

		$('.img-detail').click(function(){
			$('.img-modal-detail').attr('src', $(this).attr('src'))
			$('#imageModal').modal('show')
		})
    })

    let slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
    var i;
        var slides = document.getElementsByClassName("mySlides");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex-1].style.display = "block";
    }
</script>
@endsection