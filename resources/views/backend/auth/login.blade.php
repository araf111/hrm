<!DOCTYPE html>
<html>
<head>
  <title>HRM || Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/allcss">
  <link rel="stylesheet" href="{{asset('public/backend/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/backend/plugins/toastr/toastr.min.css')}}">  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.js"></script>
  <script src="{{asset('public/backend/plugins/toastr/toastr.min.js')}}"></script>
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Numans');
    html,body{
      background-image: url("{{asset('public/background.jpg')}}");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      font-family: 'Numans', sans-serif;
      height: 100%;
      overflow: hidden;
    }

    .container{
      height: 100%;
      align-content: center;
    }

    .card{
     margin-top: auto;
     margin-bottom: auto;
     padding-bottom: 30px;
     width: 400px;
     background-color: rgb(255,87,51,0.5) !important;
     border-radius: 25px;
   }

   .social_icon span{
    font-size: 60px;
    margin-left: 10px;
    color: #FFC312;
  }

  .social_icon span:hover{
    color: white;
    cursor: pointer;
  }

  .card-header h3{
    color: white;
  }
  .card-body {
    -ms-flex: 0;
    flex: 0;
}

  .social_icon{
    position: absolute;
    right: 20px;
    top: -45px;
  }

  .input-group-prepend span{
    width: 50px;
    background-color: rgb(0,128,255);
    color: black;
    border:0 !important;
  }

  input:focus{
    outline: 0 0 0 0  !important;
    box-shadow: 0 0 0 0 !important;

  }

  .remember{
    color: white;
  }

  .remember input
  {
    width: 20px;
    height: 20px;
    margin-left: 15px;
    margin-right: 5px;
  }

  .login_btn{
    color: black;
    background-color: rgb(0,128,255);
    width: 100px;
    font-weight: bold;
  }

  .login_btn:hover{
    color: black;
    background-color: white;
  }

  .links{
    color: white;
  }

  .links a{
    margin-left: 4px;
  }

  .navbar-nav {
    flex-direction: column !important;
  }
  .navbar-expand-lg .navbar-toggler {
      display: block !important;
      position: fixed;
      left: 30px;
      top: 20px;
      transition-duration: 1s;
  }
  .navbar-expand-lg .navbar-toggler.open{
    display: block !important;
    left: 275px;
  }
  .navbar-expand-lg .navbar-collapse{
    display: block !important;
  }
  .offcanvas-collapse {
    position: fixed;
    width: 250px;
    top: 15px;
    bottom: 0;
    left:-250px;
    padding-right: 1rem;
    padding-left: 1rem;
    padding-top: 1rem;
    overflow-y: auto;
    visibility: hidden;
    background-color: #1a1335;
    color: #fff;
    font-size: 14px;
    transition-duration: 1s;
  }
  .offcanvas-collapse.open {
    visibility: visible;
    left:0px;
    display: block !important;
    
  }
  .dropdown-menu {
    width: 100%;
    background-color: #0d0b27;
    border-radius: 0;
  }
  .dropdown-item {
    font-size: 14px;
    padding-left: 10px;
    color: #fff;

  }
  .nav-link.dropdown-toggle{
    background: #2e1e4a;
  }
  .dropdown-toggle::after{
    right: 10px;
    position: absolute;
    top: 45%;
  }
</style>
</head>
<body>
  <div class="container-float mt-4">
    <div class="col-12 text-center">
      <img src="{{asset('public/frontend/images/byte-solution.png')}}" width="120px" alt="bangladesh_jatiya_sangsad_logo">
    </div>
    <div class="col-12 text-center mt-2 mb-3">
      <h5 style="font-weight: bold; color:#ffc312; text-shadow: 1px 1px 2px #000;">
        <span style="font-size:18px; color:#fff;">Human Resource Management System<span></h5>
    </div>
    <div class="d-flex justify-content-center h-100 animate__animated" id="sign_in_div">
      <div class="card">
        <div class="card-header text-center" style="padding-bottom: 0px;">
          <img style="width: 55px;height: 60px;" src="{{asset('public/lock_logo.jpg')}}" alt="User Icon" />
        </div>
        <div class="card-body">
          <form id="submitForm">
            @csrf
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input type="email" name="email" class="email form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}">
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{$message}}</strong>
              </span>
              @enderror
            </div>
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" name="password" class="password form-control @error('password') is-invalid @enderror" placeholder="Password">
              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{$message}}</strong>
              </span>
              @enderror

            </div>
            <div class="row align-items-center remember">
              <input type="checkbox">Remember Me
            </div>
            <div class="form-group" style="margin-top: 5px;">
              <input type="submit" value="Login" class="btn btn-block login_btn">
            </div>
          </form>
        </div>
        <div>
          <div class="d-flex justify-content-center">
            <a href="{{url('/') }}" class="btn btn-success" style="text-decoration: none;color: #fff;cursor: pointer;"><i class="fa fa-home"></i> Back to Home</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>
<script type="text/javascript">
  $(function(){
    $(document).on('click','#sign_in',function(){
      if($('#sign_in_div').hasClass('d-flex')){
        $('#sign_in_div').removeClass('animate__fadeInDown').addClass('animate__fadeOutUp');
      }else{
        $('#sign_in_div').removeClass('animate__fadeOutUp').addClass('d-flex animate__fadeInDown');
      }
    });

      toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }

  });
</script>

<script>
  $(document).ready(function(){
    $('#submitForm').validate({
      ignore:[],
      errorPlacement: function(error, element){
        if(element.hasClass("email")){error.insertAfter(element.parents('.input-group')); }
        else if(element.hasClass("password")){error.insertAfter(element.parents('.input-group')); }
        else{error.insertAfter(element);}
      },
      errorClass:'text-danger',
      validClass:'text-success',

      submitHandler: function (form) {
        event.preventDefault();
        $('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');
        var formInfo = new FormData($("#submitForm")[0]);
        console.log(formInfo);
        $.ajax({
          url : "{{route('login')}}",
          data : formInfo,
          type : "POST",
          processData: false,
          contentType: false,
          beforeSend : function(){
            $('.preload').show();
          },
          success:function(data){
            $('#toast-container').html('');
            if(data.status == 'success'){
              toastr.success("",data.message);
              $('.preload').hide();
              setTimeout(function(){
                location.replace("{{route('login')}}");
              }, 1000);
            }else if(data.status == 'error'){
              toastr.error("",data.message);
              $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
              $('.preload').hide();
            }else{
              toastr.error('দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {globalPosition: 'top right',className: 'error',autoHideDelay:10000});
              $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
              $('.preload').hide();
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            toastr.error('দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {globalPosition: 'top right',className: 'error',autoHideDelay:10000});
            $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
            $('.preload').hide();
          }
        });
      }
    });

    jQuery.validator.addClassRules({
      'email' : {
        required : true
      },
      'password' : {
        required : true
      }
    });
  });


  (function navScript() {
      "use strict";
      const offcanvasToggle = document.querySelector(
        '[data-bs-toggle="offcanvas"]',
      );


      const dropdownToggle = document.querySelector(
        '[data-bs-toggle="dropdown"]',
      );

      const offcanvasCollapse = document.querySelector(".offcanvas-collapse");
      const dropdownMenu = document.querySelector(".dropdown-menu");

      // offcanvasToggle.addEventListener("click", function () {
      //   offcanvasCollapse.classList.toggle("open");
      //   offcanvasToggle.classList.toggle("open");
      // });
      // dropdownToggle.addEventListener("click", function () {
      //   dropdownMenu.classList.toggle("show");
      //   dropdownToggle.setAttribute("aria-expanded", "true");
        
      // });

    })();
</script>

</html>