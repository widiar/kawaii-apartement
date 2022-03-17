@extends('template.master')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <div class="text-center">
            <h1>{{ $room->jenis }}</h1>
            @foreach ($room->image as $item)
            <a class="venobox" data-gall="roomPhotos" href="{{Storage::url('rooms/image/') . $item->image}}" style="display: {{ ($loop->first) ? '' : 'none' }}">
                <img src="{{ Storage::url('rooms/image/') . $item->image }}" alt="" class="img-thumbnail w-100" style="height: 300px;object-fit: cover;object-position: center;">
            </a>
            @endforeach
        </div>
        <div class="price text-center" style="margin-top: 50px">
            <h2>{{ __('site.price') }} Rp {{ number_format($room->harga, 0, ',', '.') }} /{{ __('site.txt-night') }}</h2>
        </div>
        <div id="hotel-facilities">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title text-center">
                            <h2>{{ __('site.facilities.title') }}</h2>
                        </div>
                    </div>
                </div>
        
                <div id="tabs">
                    <nav class="tabs-nav">
                        @php
                            $w = (100)/count(json_decode($room->fasilitas));
                            $c = 1;
                            $lang = app()->getLocale();
                        @endphp
                        @foreach(json_decode($room->fasilitas) as $fasilitas)
                        <a href="#" class="@if($loop->first)active @endif" data-tab="tab{{ $c++ }}" style="width: {{ $w }}%">
                            <i class="fa fa-{{ strtolower($fasilitas->icon) }} icon"></i>
                            <span>{{ $fasilitas->title->$lang }}</span>
                        </a>
                        @endforeach
                    </nav>
                    @php
                        $i = 1;
                    @endphp
                    <div class="tab-content-container">
                        @foreach(json_decode($room->fasilitas) as $fasilitas)
                        <div class="tab-content @if($loop->first)active show @endif" data-tab-content="tab{{ $i++ }}">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="heading">{{ $fasilitas->title->$lang }}</h3>
                                        <p>{{ $fasilitas->description->$lang }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>        
        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#bayarModal">{{ __('site.btn-book') }}</button>
    </div>
</div>

<div class="modal fade" id="bayarModal" tabindex="-1" role="dialog" aria-labelledby="pembayaranModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="pembayaranModal">Detail</h3>
            </div>
            <form action="{{ route('room.reservasi', [$lang, $room->id]) }}" method="POST" id="form-reservasi">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ __('site.tanggal') }} Chekin</label>
                        <input name="checkin" id="checkin" autocomplete="off" required type="text" class="form-control tanggal"
                            value="{{ @$carts[0]->tanggal }}">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('site.tanggal') }} Checkout</label>
                        <input name="checkout" id="checkout" autocomplete="off" disabled title="Harap Pilih Tanggal Checkin Terlebih Dahulu" required type="text" class="form-control tanggal"
                            value="{{ @$carts[0]->jam }}">
                    </div>
                    <div class="form-group">
                        <label for="nama">{{ __('site.nama') }}</label>
                        <input type="text" required class="form-control" name="nama"
                            placeholder="{{ __('site.masukkan') }} {{ __('site.nama') }}" value="{{ @$user->nama }}">
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" required class="form-control" name="nik" placeholder="{{ __('site.masukkan') }} NIK"
                            value="{{ @$user->nik }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" required class="form-control" name="email"
                            placeholder="{{ __('site.masukkan') }} Email" value="{{ @$user->nama }}">
                        <small class="text-info"><i>*{{ __('site.info-email') }}</i></small><br>
                    </div>
                    <div class="form-group">
                        <label for="tlp">{{ __('site.telepon') }}</label>
                        <input type="text" required class="form-control" name="tlp"
                            placeholder="{{ __('site.masukkan') }} {{ __('site.telepon') }}" value="{{ @$user->no_tlp }}">
                    </div>
                    <button type="button" class="btn btn-sm btn-primary m-2" id="apply-promo">{{ __('site.voucher-apply') }}</button>
                    <span class="text-info info-voucher" style="display: none"></span>
                    <h3>
                        Total {{ __('site.bayar') }} Rp <span class="bayar">{{ number_format($room->harga, '0', '.', '.') }}</span>
                    </h3>
                    <input type="hidden" name="jumlahhari" id="hari">
                    <input type="hidden" id="harga" value="{{ $room->harga }}">
                    <input type="hidden" name="room" value="{{ $room->id }}">
                    <input type="hidden" name="totalHarga" value="{{ $room->harga }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">{{ __('site.bayar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="voucherModal" role="dialog" aria-labelledby="voucherModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Voucher</h3>
            </div>
            <form action="{{ route('check.voucher', $lang) }}" id="form-promo" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="voucher">{{ __('site.voucher') }}</label>
                        <input type="text" class="form-control" name="voucher" id="voucher" autocomplete="off"
                            placeholder="{{ __('site.masukkan') }} {{ __('site.voucher') }}" value="{{ @$user->voucher }}">
                        <span class="text-danger invalid-voucher" style="display: none"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="transaksiModal" data-backdrop="static" role="dialog" aria-labelledby="pembayaranModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="pembayaranModal">{{ __('site.bayar') }}</h3>
            </div>
            <form action="#" method="POST" id="form-pembayaran"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h3 class="text-center">{{ __('site.trf-bank') }}</h3>
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
                        <label for="bukti">{{ __('site.upload-bank') }}</label>
                        <div class="custom-file">
                            <input type="file" required name="bukti"
                                class="file custom-file-input @error('bukti') is-invalid @enderror" id="bukti"
                                value="{{ old('bukti') }}" accept="image/*">
                            <label class="custom-file-label" for="bukti">
                                <span class="d-inline-block text-truncate w-75">Browse File</span>
                            </label>
                            @error("bukti")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">upload format file .png, .jpg max 5mb.</small>
                    </div>
                    <img src="https://via.placeholder.com/1080x1080.png?text={{ __('site.img-bukti') }}" alt=""
                        class="img-thumbnail img-detail">
                    <small>{{ __('site.detail-img') }}</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">{{ __('site.proses-bayar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" role="dialog" aria-labelledby="pembayaranModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="pembayaranModal">{{ __('site.img-bukti') }}</h3>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js" integrity="sha512-/n/dTQBO8lHzqqgAQvy0ukBQ0qLmGzxKhn8xKrz4cn7XJkZzy+fAtzjnOQd5w55h4k1kUC+8oIe6WmrGUYwODA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
<script>


    $('body').on('hidden.bs.modal', function () {
        if($('.modal.in').length > 0)
        {
            $('body').addClass('modal-open');
        }
    });

    $('#apply-promo').click(function(e){
        e.preventDefault();
        let jumlahHari = $('#hari').val();
        if(jumlahHari == ''){
            Swal.fire(
                'Oops...',
                'Silahkan isi tanggal checkin dan checkout terlebih dahulu',
                'warning'
            )
        } else {
            $('#voucherModal').modal('show');
        }
    })
    let urlCheck = `{{ route('api.check.room') }}`

    $(document).ready(function(){
        new VenoBox();

        $('#form-promo').validate({
            rules: {
                voucher: {
                    required: true,
                }
            },
            submitHandler: (form, e) => {
                e.preventDefault();
                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: $(form).serialize(),
                    success: (res) => {
                        if(res.status == 'success'){
                            $('#voucherModal').modal('hide');
                            $('.info-voucher').text('Voucher applied');
                            $('.info-voucher').show()
                            let harga = $('#harga').val();
                            let hari = $('#hari').val();
                            let totalHarga = parseInt(harga) * parseInt(hari);
                            let diskon = 0
                            if(res.voucher.type == 'percentage'){
                                diskon = (totalHarga * res.voucher.value) / 100;
                            } else{
                                diskon = res.voucher.value;
                            }
                            totalHarga = totalHarga - diskon;
                            $('input[name="totalHarga"]').val(totalHarga);
                            $('.bayar').text(toRupiah(totalHarga));
                        } else{
                            $('.invalid-voucher').text(res.message);
                            $('.invalid-voucher').show();
                        }
                    },
                    error: (res) => {
                        console.log(res.responseJSON)
                    }
                })
            }
        })

        $('#form-reservasi').validate({
            rules: {
                checkin: 'required',
                checkout: 'required',
                nama: 'required',
                email: {
                    required: true,
                    email: true,
                },
                nik: {
                    required: true,
                    digits: true,
                },
                tlp: {
                    required: true,
                    digits: true,
                }
            },
            submitHandler: (form, e) => {
                e.preventDefault()
                // console.log($(form).serialize())
                let dataform = new FormData($('#form-reservasi')[0])
                dataform.append('voucher', $('#voucher').val())
                Swal.fire({
                    title: 'Checking',
                    timer: 20000,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                        Swal.stopTimer()
                        $.ajax({
                            url: $(form).attr('action'),
                            data: dataform,
                            type: 'POST',
                            contentType: false, 
                            processData: false,
                            success: (res) => {
                                Swal.close()
                                console.log(res)
                                if(res.status == 200) {
                                    // xendit
                                    window.location.href = res.data.invoice_url
                                } else {
                                    Swal.fire({
                                        title: 'Sorry',
                                        icon: 'warning',
                                        html: res.message,
                                    })
                                }
                            },
                            error: (err) => {
                                console.log(err.responseJSON)
                            }
                        })
                    }
                })
            }
        })

        $('#form-pembayaran').validate({
            rules: {
                bukti: 'required'
            },
            submitHandler: (form, e) => {
                e.preventDefault()
                let dataform = new FormData($('#form-reservasi')[0])
                dataform.append('bukti', $('#bukti')[0].files[0])
                dataform.append('voucher', $('#voucher').val())
                //kasi swal
                Swal.fire({
                    title: 'Loading',
                    timer: 20000,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                        Swal.stopTimer()
                        $.ajax({
                            url: `{{ route('room.reservasi', [$lang, $room->id]) }}`,
                            data: dataform,
                            type: 'POST',
                            contentType: false, 
                            processData: false,
                            success: (res) => {
                                Swal.close()
                                if(res.status == 'success') {
                                    Swal.fire({
                                        title: 'Success',
                                        icon: 'success',
                                        html: `{!! __('site.swal-bayar') !!}`,
                                    }).then(res => {
                                        if(res.isConfirmed) window.location.href = ''
                                    })
                                }
                            },
                            error: (err) => {
                                console.log(err.responseJSON)
                            }
                        })
                    }
                })
            }
        })
        $('#bukti').change(function(e){
			let url = URL.createObjectURL(e.target.files[0])
			$(".img-detail").attr("src", url)
		})

		$('.img-detail').click(function(){
			$('.img-modal-detail').attr('src', $(this).attr('src'))
			$('#imageModal').modal('show')
		})

        $('.tanggal').datepicker({
            startDate: "today",
			format: 'yyyy-mm-dd',
            orientation: 'auto bottom',
            autoclose: true,
        })

        $("#checkin").datepicker({
            startDate: "today",
		}).on('changeDate', function(selected){
            let minDate = new Date(selected.date.valueOf()).addDays(1);
            $('#checkout').datepicker('setStartDate', minDate);
        });

        $('#checkin').change(function(){
            $('#checkout').val(null)
            if($(this).val() != ''){
                $('#checkout').removeAttr('disabled')
            }else{
                $('#checkout').attr('disabled', 'disabled')
            }
        })

        $('#checkout').datepicker().on('changeDate', function(selected){
            let cekin = dayjs($("#checkin").val())
            let cekot = dayjs(selected.date.valueOf())
            $('#hari').val((cekot.diff(cekin, 'day')))
            let totalHarga = $('#hari').val() * $('#harga').val()
            $('.bayar').text(toRupiah(totalHarga))
            $('input[name="totalHarga"]').val(totalHarga);
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