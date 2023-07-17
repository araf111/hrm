<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        body {font-family: 'nikosh', Poppins, sans-serif; }
        @page {
            margin-bottom: 100px;
        }
        footer {
            position: fixed; 
            bottom: -80px; 
            left: 0px; 
            right: 0px;
        }
        /* Header */
        .report_header{border-bottom: 1px solid #444; display: flex; margin-bottom: 30px;}
        .report_header .logo_left{width:25%; float: left; text-align: left; }
        .report_header .header_title{width:50%; float: left;text-align: center;}
        .report_header .logo_right{width:25%; float: left; text-align: right;}
        /* Footer */
        .report_footer{border-top: 1px solid #444; margin-top: 30px;}
        .report_footer .copyright{text-align: center;}
        .report_footer .copyright h4{font-size: 18px;}
        .report_footer .left{text-align: left; font-size: 14px;line-height: 14px;}
        .report_footer .right{text-align: right; font-size: 14px;line-height: 14px;}
        /* Profile */
        .report_profile .profile_headar{text-align: left; }
        .report_profile .profile_headar .left{width:75%; float: left; }
        .report_profile .profile_headar .right{width:25%; float: left; text-align: right;}
        .report_profile table tbody tr th{text-align: left;}
        .report_profile .card-title{background: #28a745!important; color: #fff!important;padding: .5rem!important;}
    </style>
    
    <!-- Latest jQuery --> 
    <script src="{{asset('public/backend/plugins/jquery/jquery.min.js')}}"></script>


</head>
<body>
<header>
    <section class="report_header">
        <div class="container">
            <div class="row">
                <div class="col-2 logo_left">
                    <img style="height: 55px;" src="{{asset( 'public/images/govt-Logo.png')}}" alt="">
                </div>
                <div class="col-8 header_title">
                    <img style="height: 70px; padding-bottom: 10px;" src="{{asset( 'public/images/parliament.png')}}" alt="">
                </div>
                <div class="col-2 logo_right">
                    <img  style="height: 55px" src="{{asset( 'public/frontend/images/100years_suborno_joyonti.png')}}" alt="">
                </div>
            </div>
        </div>
    </section>
</header>