<!DOCTYPE html>
<html lang="en">

<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Bangladesh National Parliament">
<meta name="keywords" content="">

<!-- SITE TITLE -->
<title>@lang('MP Portal') | @lang('Bangladesh National Parliament')</title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/images/logo.png')}}">
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.min.css')}}">
<!-- Animation CSS -->
<link rel="stylesheet" href="{{asset('public/frontend/css/animate.css')}}">	
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
<!-- Icon Font CSS -->
<link rel="stylesheet" href="{{asset('public/frontend/css/ionicons.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/themify-icons.css')}}">
<!-- FontAwesome CSS -->
<link rel="stylesheet" href="{{asset('public/frontend/fonts/fontawesome-free/css/brands.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/fonts/fontawesome-free/css/solid.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/fonts/fontawesome-free/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/fonts/fontawesome-free/css/svg-with-js.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/fonts/fontawesome-free/css/v4-shims.min.css')}}">

<!--- owl carousel CSS-->
<link rel="stylesheet" href="{{asset('public/frontend/css/owl.carousel.min.css')}}">

<!--- Datepicker CSS-->
<link rel="stylesheet" href="{{ asset('public/backend') }}/plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
crossorigin="anonymous" />

<link rel="stylesheet" href="{{ asset('public/backend/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/backend/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/backend/plugins/toastr/toastr.min.css') }}">

<style type="text/css">
    .focusedInput {
        border-color: rgb(247 60 60) !important;
        outline: 0;
        outline: thin dotted \9;
        -moz-box-shadow: 0 0 3px rgba(255, 0, 0);
        box-shadow: 0 0 3px rgba(255,0,0) !important;
    }
	@font-face {
		font-family: 'nikosh';
		src: url("{{ asset('public/fonts/NikoshBAN.ttf') }}");
	}
</style>


<!-- Style CSS -->
<link rel="stylesheet" href="{{asset('public/frontend/css/styles.css')}}">

<!-- Latest jQuery --> 
<script src="{{asset('public/backend/plugins/jquery/jquery.min.js')}}"></script>

</head>

<body>




@yield('content')




<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a> 



<!-- Latest Bootstrap --> 
<script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script> 
<!-- popper min js --> 
<script src="{{asset('public/frontend/js/popper.min.js')}}"></script>
<!-- owl-carousel min js  --> 
<script src="{{asset('public/frontend/js/owl.carousel.min.js')}}"></script> 
<!-- daterangepicker -->
<script src="{{ asset('public/backend') }}/plugins/moment/moment.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/daterangepicker/daterangepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous"></script>

<script src="{{ asset('public/backend/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/toastr/toastr.min.js') }}"></script>

@yield('scripts')

<script>


	$(function() {
		$('.select2').select2();
	});

	// Remove extra space inside textarea
	$('document').ready(function() {
		$('textarea').each(function() {
			$(this).val($(this).val().trim());
		});
	});

    /*===================================*
	SCROLLUP JS
	*===================================*/
	$(window).scroll(function() {
		if ($(this).scrollTop() > 150) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});
	
	$(".scrollup").on('click', function (e) {
		e.preventDefault();
		$('html, body').animate({
			scrollTop: 0
		}, 600);
		return false;
	});

	/* reset form validation while typing/changing  */
	$(document).ready(function() {
            nanoResetFormControl();
	});

	function nanoResetFormControl() {
		$("input").change(function() {
			$(this).siblings('.text-danger').empty();
		});
		$("select").change(function() {
			$(this).siblings('.text-danger').empty();
		});
		$("textarea").change(function() {
			$(this).siblings('.text-danger').empty();
		});

		$(".file").change(function() {
			$(this).siblings('.text-danger').empty();
		});

		$(".note-editor").on('change keyup paste', function() {
			$(this).siblings('.text-danger').empty();
		});
	}



	/* =============================================== */
	

	function capitalize(str) {
		strVal = '';
		str = str.split(' ');
		for (var chr = 0; chr < str.length; chr++) {
			strVal += str[chr].substring(0, 1).toUpperCase() + str[chr].substring(1, str[chr].length) + ' '
		}
		return strVal
	}

</script>
<script>
	/* =============================================== */
	/* for language translation in javascript */
	String.prototype.replaceArray = function (find, replace) {
	  var replaceString = this;
	  for (var i = 0; i < find.length; i++) {
		  // global replacement
		  var pos = replaceString.indexOf(find[i]);
		  while (pos > -1) {
			  replaceString = replaceString.replace(find[i], replace[i]);
			  pos = replaceString.indexOf(find[i]);
		  }
	  }
	  return replaceString;
	};
  
	function nanoLangTranslate(number,type=null){
		var en = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "AM", "PM", "am", "pm", "cusec", "litre", "horse", "Jan", "Feb", "Mar", "Apr", "May", "Jun", 'Jul', "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", 'July', "August", "September", "October", "November", "December", "Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Weekend", "day", "week", "month", "year"];
		var bn = ["১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "এ.এম", "পি.এম", "এ.এম", "পি.এম", "কিউসেক", "লিটার/সে.", "অশ্বশক্তি", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "শনিবার", "রবিবার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "সাপ্তাহিক ছুটি", "দিন", "সপ্তাহ", "মাস", "বছর"];
  
		if(type!=null){
			if(type=='bn'){
				return number.replaceArray(en,bn);
			}
			else{
				return number.replaceArray(bn,en);
			}
		}
		else{
			@php if (Session::get('language') == 'bn') { @endphp
			return number.replaceArray(en,bn);
		@php } else { @endphp
			return number.replaceArray(bn,en);
		@php } @endphp
		}
	}

	/* ================== */

	/* common daterange objects */

	var daterange_locale = {
		"applyLabel": '@lang("Apply")',
		"cancelLabel": '@lang("Cancel")',
		"fromLabel": '@lang("From")',
		"toLabel": '@lang("To")',
		"customRangeLabel": '@lang("Custom")',
		language: 'bn',
		format: 'DD-MM-YYYY',
		monthNames: ["@lang('January')", "@lang('February')", "@lang('March')", "@lang('April')", "@lang('May')", "@lang('June')", "@lang('July')", "@lang('August')", "@lang('September')", "@lang('October')", "@lang('November')", "@lang('December')"],
		daysOfWeek: ["@lang('Sun')", "@lang('Mon')", "@lang('Tue')", "@lang('Wed')", "@lang('Thu')",
			"@lang('Fri')", "@lang('Sat')"
		],
		firstDay: 0
	};
	var daterange_ranges = {
		'@lang("Today")': [moment(), moment()],
		'@lang("Yesterday")': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		'@lang("Last 7 Days")': [moment().subtract(6, 'days'), moment()],
		'@lang("Last 30 Days")': [moment().subtract(29, 'days'), moment()],
		'@lang("This Month")': [moment().startOf('month'), moment().endOf('month')],
		'@lang("Last Month")': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	};

  
  </script>

</body>

</html>