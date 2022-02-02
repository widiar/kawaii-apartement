<footer id="footer" class="fh5co-bg-color">
    <div class="container">
        <div class="text-center">
            <p><small>&copy; 2016 Free HTML5 Template. <br> All Rights Reserved. <br>
            <ul class="social-icons">
                <li>
                    <a href="#"><i class="icon-twitter-with-circle"></i></a>
                    <a href="#"><i class="icon-facebook-with-circle"></i></a>
                    <a href="#"><i class="icon-instagram-with-circle"></i></a>
                    <a href="#"><i class="icon-linkedin-with-circle"></i></a>
                </li>
            </ul>
        </div>
    </div>
</footer>

</div>
<!-- END fh5co-page -->

</div>
<!-- END fh5co-wrapper -->

<!-- Javascripts -->
<script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
<!-- Dropdown Menu -->
<script src="{{ asset('js/hoverIntent.js') }}"></script>
<script src="{{ asset('js/superfish.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- Waypoints -->
<script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
<!-- Counters -->
<script src="{{ asset('js/jquery.countTo.js') }}"></script>
<!-- Stellar Parallax -->
<script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
<!-- Owl Slider -->
<!-- // <script src="js/owl.carousel.min.js"></script> -->
<!-- Date Picker -->
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<!-- CS Select -->
<script src="{{ asset('js/classie.js') }}"></script>
<script src="{{ asset('js/selectFx.js') }}"></script>
<!-- Flexslider -->
<script src="{{ asset('js/jquery.flexslider-min.js') }}"></script>

<script src="{{ asset('plugins/venobox/venobox.min.js') }}"></script>

<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script src="{{ asset('js/custom.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    function toRupiah(value) {
        let reverse = value.toString().split('').reverse().join('')
        let val = reverse.match(/\d{1,3}/g)
        val = val.join('.').split('').reverse().join('')
        return val
    }
    jQuery.validator.setDefaults({
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback text-danger');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
</script>
@yield('javascript')