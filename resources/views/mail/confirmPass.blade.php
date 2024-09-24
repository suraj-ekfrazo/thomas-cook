<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thomas Cook</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/forntEndAssets/style2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/forntEndAssets/style3.css')}}">
   
  </head>
    <body>
    <div class="image">
        <img src="{{asset('public/forntEndAssets/images/1-Website-Login1366.jpg')}}" class="img-responsive" />
        <div class="login">
            <div class="bg-login">
                <div class="login-part">


                        @if (Session::has('otpError'))
                        <div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong>{{Session::get('otpError')}}</strong>
                        </div>
                        @endif

                        @if (Session::has('passwordError'))
                        <div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong>{{Session::get('passwordError')}}</strong>
                        </div>
                        @endif

                        @if (Session::has('passwordSuccess'))
                        <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong>{{Session::get('passwordSuccess')}}</strong>
                        </div>
                        @endif

                        @if (Session::has('passwordLessthen'))
                        <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                             <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif


                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 left-side-img">
                        <img src="{{asset('public/forntEndAssets/images/2-Website-Change-Password.png')}}" alt="" class="img-responsive">
                        <img src="{{asset('public/forntEndAssets/images/login-city1.png')}}" alt="">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 right-side-new">
                        <img src="{{asset('public/forntEndAssets/images/login-logo.png')}}" alt="" class="img-responsive">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <h3><span>CHANGE YOUR<br> PASSWORD</span></h3>
                        </div>
                        <form method="post" action="{{URL::to('confirmPassword')}}" class="login-form-part">
                            @csrf

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form" name="otp" placeholder="Enter Your OTP"/>
                            </div> 
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
                                <input type="password" class="form" name="first_password" placeholder="New Password"/><i class="fas fa-lock"></i>
                            </div> 
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
                                <input type="password" class="form"  name="second_password" placeholder="Confirm Password"/><i class="fas fa-lock"></i>
                            </div>   
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <button type="submit" class=" btn-login">Submit</button> 
                            </div>
                            
                        </form>
                        <div class="back-button1"><a href="{{URL::to('forgotPassword')}}"><i class="fas fa-long-arrow-alt-left"></i></a></div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
        
            


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


    </body>
</html>      