@extends('template.master')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('main-content')
<aside id="fh5co-hero" class="js-fullheight">
    <div class="flexslider js-fullheight">
        <ul class="slides">
            @php
                $lang = app()->getLocale();
            @endphp
            @foreach ($banner as $bn)
                <li style="background-image: url({{Storage::url('banner/') . $bn->foto}});">
                    <div class="overlay-gradient"></div>
                    <div class="container">
                        <div class="col-md-12 col-md-offset-0 text-center slider-text">
                            <div class="slider-text-inner js-fullheight">
                                <div class="desc">
                                    <p><span>Kawaii Apartement</span></p>
                                    <h2>{{ json_decode($bn->title)->$lang }}</h2>
                                    <p>
                                        <a href="#rooms" class="btn btn-primary btn-lg">{{ __('site.btn-book') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
<div class="wrap" style="margin-bottom: 0">
    <div class="container">
        <div class="row">
            <div id="availability">
                <form action="#" method="POST" id="form-check-ava">
                    @csrf
                    <div class="a-col">
                        <section>
                            <select class="cs-select cs-skin-border" name="room" class="required">
                                <option disabled value="" selected>Select Room</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->jenis }}</option>
                                @endforeach
                            </select>
                        </section>
                    </div>
                    <div class="a-col alternate">
                        <div class="input-field">
                            <label for="date-start">Check In</label>
                            <input type="text" class="form-control tanggal" name="checkin" required />
                        </div>
                    </div>
                    <div class="a-col alternate">
                        <div class="input-field">
                            <label for="date-end">Check Out</label>
                            <input type="text" class="form-control tanggal" name="checkout" required />
                        </div>
                    </div>
                    <div class="a-col action">
                        <a href="#" id="form-check">
                            <span>Check</span>
                            Availability
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="rooms">
    <div id="fh5co-hotel-section" class="fh5co-bg-color">
        <div class="container">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h2>{{ __('site.txt-room') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($rooms as $room)
                <div class="col-md-4">
                    <div class="hotel-content">
                        <div class="hotel-grid" style="background-image: url({{Storage::url('rooms/image/') . $room->image[0]->image}});">
                            <div class="price"><span>Rp {{ number_format($room->harga, 0, ',', '.') }} /{{ __('site.txt-night') }}</span></div>
                            <a class="book-now text-center" href="{{ route('room.detail', [$lang, $room->id]) }}"><i class="ti-calendar"></i> {{ __('site.btn-book') }}</a>
                        </div>
                        <div class="desc">
                            <h3><a href="{{ route('room.detail', [$lang, $room->id]) }}">{{ $room->jenis }}</a></h3>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>
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
                <a href="#" class="active" data-tab="tab1">
                    <i class="fas fa-hands-wash icon"></i>
                    <span>{{ __('site.facilities.1') }}</span>
                </a>
                <a href="#" data-tab="tab2">
                    <i class="fas fa-parking icon"></i>
                    <span>{{ __('site.facilities.2') }}</span>
                </a>
                <a href="#" data-tab="tab3">
                    <i class="fas fa-wifi icon"></i>
                    <span>{{ __('site.facilities.3') }}</span>
                </a>
            </nav>
            <div class="tab-content-container">
                <div class="tab-content active show" data-tab-content="tab1">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/tab_img_1.jpg" class="img-responsive" alt="Image" style="width: 100%; height: 333px;">
                            </div>
                            <div class="col-md-6">
                                <h3 class="heading">{{ __('site.facilities.1') }}</h3>
                                <p>{{ __('site.facilities.text-1') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" data-tab-content="tab2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/tab_img_2.jpg" class="img-responsive" alt="Image" style="width: 100%; height: 333px">
                            </div>
                            <div class="col-md-6">
                                <h3 class="heading">{{ __('site.facilities.2') }}</h3>
                                <p>{{ __('site.facilities.text-2') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" data-tab-content="tab3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/tab_img_2.jpg" class="img-responsive" alt="Image" style="width: 100%; height: 333px">
                            </div>
                            <div class="col-md-6">
                                <h3 class="heading">{{ __('site.facilities.3') }}</h3>
                                <p>{{ __('site.facilities.text-3') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="place" style="clear: both; margin-bottom: 5em;">
    <div class="container">
        <div class="section-title text-center" style="margin-bottom: 0">
            <h2>{{ __('site.location') }}</h2>
            <hr>
        </div>
        <div class="maps">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.0109742117775!2d115.1741377509511!3d-8.785036693659348!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd244900b9318fd%3A0x9796a34293835fa4!2sKawaii%20Apartments!5e0!3m2!1sen!2sid!4v1644518363742!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    let urlCheck = `{{ route('api.check.room') }}`

    $.validator.addMethod("valueNotEquals", function(value, element, arg){
        return arg !== value;
    }, "Value must not equal arg.");

    $('.tanggal').datepicker({
        startDate: "today",
        format: 'yyyy-mm-dd',
        orientation: 'auto bottom',
        autoclose: true,
    })

    $('#form-check-ava').validate({
        rules: {
            checkin: 'required',
            checkout: 'required',
            room: {
                valueNotEquals: 'default'
            },
        },
        submitHandler: (form, e) => {
            e.preventDefault()
            let checkselect = $('select[name="room"]').val()
            if(checkselect == null) {
                alert('Please select room')
            } else {
                Swal.fire({
                    title: 'Checking',
                    timer: 20000,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                        Swal.stopTimer()
                        $.ajax({
                            url: urlCheck,
                            data: $(form).serialize(),
                            type: 'POST',
                            success: (res) => {
                                Swal.close()
                                console.log(res)
                                if(res.status == 200) {
                                    Swal.fire({
                                        title: 'Check Room',
                                        icon: 'success',
                                        html: res.message,
                                    })
                                } else {
                                    Swal.fire({
                                        title: 'Check Room',
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
        }
    })

    $('body').on('click', '#form-check', function(e){
        e.preventDefault()
        $('#form-check-ava').submit()
        return
    })
</script>
@endsection