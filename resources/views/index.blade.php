@extends('template.master')

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
                    <h2>Our Facilities</h2>
                </div>
            </div>
        </div>

        <div id="tabs">
            <nav class="tabs-nav">
                <a href="#" class="active" data-tab="tab1">
                    <i class="flaticon-restaurant icon"></i>
                    <span>Restaurant</span>
                </a>
                <a href="#" data-tab="tab2">
                    <i class="flaticon-cup icon"></i>
                    <span>Bar</span>
                </a>
                <a href="#" data-tab="tab3">
                
                    <i class="flaticon-car icon"></i>
                    <span>Pick-up</span>
                </a>
                <a href="#" data-tab="tab4">
                    
                    <i class="flaticon-swimming icon"></i>
                    <span>Swimming Pool</span>
                </a>
                <a href="#" data-tab="tab5">
                    
                    <i class="flaticon-massage icon"></i>
                    <span>Spa</span>
                </a>
                <a href="#" data-tab="tab6">
                    
                    <i class="flaticon-bicycle icon"></i>
                    <span>Gym</span>
                </a>
            </nav>
            <div class="tab-content-container">
                <div class="tab-content active show" data-tab-content="tab1">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/tab_img_1.jpg" class="img-responsive" alt="Image">
                            </div>
                            <div class="col-md-6">
                                <span class="super-heading-sm">World Class</span>
                                <h3 class="heading">Restaurant</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias officia perferendis modi impedit, rem quasi veritatis. Consectetur obcaecati incidunt, quae rerum, accusamus sapiente fuga vero at. Quia, labore, reprehenderit illum dolorem quae facilis reiciendis quas similique totam sequi ducimus temporibus ex nemo, omnis perferendis earum fugit impedit molestias animi vitae.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam neque blanditiis eveniet nesciunt, beatae similique doloribus, ex impedit rem officiis placeat dignissimos molestias temporibus, in! Minima quod, consequatur neque aliquam.</p>
                                <p class="service-hour">
                                    <span>Service Hours</span>
                                    <strong>7:30 AM - 8:00 PM</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" data-tab-content="tab2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/tab_img_2.jpg" class="img-responsive" alt="Image">
                            </div>
                            <div class="col-md-6">
                                <span class="super-heading-sm">World Class</span>
                                <h3 class="heading">Bars</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias officia perferendis modi impedit, rem quasi veritatis. Consectetur obcaecati incidunt, quae rerum, accusamus sapiente fuga vero at. Quia, labore, reprehenderit illum dolorem quae facilis reiciendis quas similique totam sequi ducimus temporibus ex nemo, omnis perferendis earum fugit impedit molestias animi vitae.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam neque blanditiis eveniet nesciunt, beatae similique doloribus, ex impedit rem officiis placeat dignissimos molestias temporibus, in! Minima quod, consequatur neque aliquam.</p>
                                <p class="service-hour">
                                    <span>Service Hours</span>
                                    <strong>7:30 AM - 8:00 PM</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" data-tab-content="tab3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/tab_img_3.jpg" class="img-responsive" alt="Image">
                            </div>
                            <div class="col-md-6">
                                <span class="super-heading-sm">World Class</span>
                                <h3 class="heading">Pick Up</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias officia perferendis modi impedit, rem quasi veritatis. Consectetur obcaecati incidunt, quae rerum, accusamus sapiente fuga vero at. Quia, labore, reprehenderit illum dolorem quae facilis reiciendis quas similique totam sequi ducimus temporibus ex nemo, omnis perferendis earum fugit impedit molestias animi vitae.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam neque blanditiis eveniet nesciunt, beatae similique doloribus, ex impedit rem officiis placeat dignissimos molestias temporibus, in! Minima quod, consequatur neque aliquam.</p>
                                <p class="service-hour">
                                    <span>Service Hours</span>
                                    <strong>7:30 AM - 8:00 PM</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" data-tab-content="tab4">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/tab_img_4.jpg" class="img-responsive" alt="Image">
                            </div>
                            <div class="col-md-6">
                                <span class="super-heading-sm">World Class</span>
                                <h3 class="heading">Swimming Pool</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias officia perferendis modi impedit, rem quasi veritatis. Consectetur obcaecati incidunt, quae rerum, accusamus sapiente fuga vero at. Quia, labore, reprehenderit illum dolorem quae facilis reiciendis quas similique totam sequi ducimus temporibus ex nemo, omnis perferendis earum fugit impedit molestias animi vitae.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam neque blanditiis eveniet nesciunt, beatae similique doloribus, ex impedit rem officiis placeat dignissimos molestias temporibus, in! Minima quod, consequatur neque aliquam.</p>
                                <p class="service-hour">
                                    <span>Service Hours</span>
                                    <strong>7:30 AM - 8:00 PM</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" data-tab-content="tab5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/tab_img_5.jpg" class="img-responsive" alt="Image">
                            </div>
                            <div class="col-md-6">
                                <span class="super-heading-sm">World Class</span>
                                <h3 class="heading">Spa</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias officia perferendis modi impedit, rem quasi veritatis. Consectetur obcaecati incidunt, quae rerum, accusamus sapiente fuga vero at. Quia, labore, reprehenderit illum dolorem quae facilis reiciendis quas similique totam sequi ducimus temporibus ex nemo, omnis perferendis earum fugit impedit molestias animi vitae.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam neque blanditiis eveniet nesciunt, beatae similique doloribus, ex impedit rem officiis placeat dignissimos molestias temporibus, in! Minima quod, consequatur neque aliquam.</p>
                                <p class="service-hour">
                                    <span>Service Hours</span>
                                    <strong>7:30 AM - 8:00 PM</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" data-tab-content="tab6">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/tab_img_6.jpg" class="img-responsive" alt="Image">
                            </div>
                            <div class="col-md-6">
                                <span class="super-heading-sm">World Class</span>
                                <h3 class="heading">Gym</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias officia perferendis modi impedit, rem quasi veritatis. Consectetur obcaecati incidunt, quae rerum, accusamus sapiente fuga vero at. Quia, labore, reprehenderit illum dolorem quae facilis reiciendis quas similique totam sequi ducimus temporibus ex nemo, omnis perferendis earum fugit impedit molestias animi vitae.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam neque blanditiis eveniet nesciunt, beatae similique doloribus, ex impedit rem officiis placeat dignissimos molestias temporibus, in! Minima quod, consequatur neque aliquam.</p>
                                <p class="service-hour">
                                    <span>Service Hours</span>
                                    <strong>7:30 AM - 8:00 PM</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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