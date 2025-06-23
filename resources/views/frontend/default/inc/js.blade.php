{{-- <script src="{{ asset('frontend/assets/js/vendors/jquery-3.7.1.min.js')}}"></script>
<script src="{{ asset('frontend/assets/js/vendors/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('frontend/assets/js/vendors/swiper-bundle.min.js')}}"></script>
<script src="{{ asset('frontend/assets/js/vendors/simplebar.min.js')}}"></script>
<script src="{{ asset('frontend/assets/js/vendors/jquery.magnific-popup.min.js')}}"></script>

<script src="{{ asset('frontend/assets/js/app.js')}}"></script> --}}
{{-- <script src="{{ asset('assets/js/vendors/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/basictable.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/sweetalert2@11.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script> --}}

<script src="{{ asset('frontend/assets/js/vendors/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendors/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendors/simplebar.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendors/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/app.js') }}"></script>

<script>
    $(document).on('change', '.changeLocaleLanguage', function(e){
        var locale = $(this).val();
        $.post("{{ route('backend.changeLanguage') }}", {
            _token: '{{ csrf_token() }}',
            locale: locale
        }, function(data) {
            setTimeout(() => {
                location.reload();
            }, 300);
        });
    })
    $(document).on('change', '.changeLocaleCurrency', function(e){
        var currency_code = $(this).val();
        $.post("{{ route('backend.changeCurrency') }}", {
            _token: '{{ csrf_token() }}',
            currency_code: currency_code
        }, function(data) {
            setTimeout(() => {
                location.reload();
            }, 300);
        });
    });

    
    // get & set cookie 
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
 
    $(document).on('click', '.cookie-accept', function(e){
        setCookie("acceptCookies", true, 60);
        $(".cookie-alert").removeClass("show");
    })

    if (getCookie("acceptCookies") != "true") {
        $(".cookie-alert").addClass("show");
    }

    var gFilterObj = {};


</script>