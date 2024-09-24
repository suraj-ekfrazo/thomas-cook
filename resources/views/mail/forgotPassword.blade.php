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

                    @if(Session::has('adminAlreadyExist'))
                        <div class="alert alert-danger alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <p>Admin Already Exist, Please Enter Another User Id</p>
                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            @endif
                        </div>
                    @endif


                     @if(Session::has('emailerror'))
                        <div class="alert alert-danger alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <p>Your email does not match</p>
                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            @endif
                        </div>
                    @endif

                    @if(Session::has('adminSuccess'))
                        <div class="alert alert-success alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <p>Data Inserted SuccessFully</p>
                        </div>
                    @endif


                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 left-side-img">
           <!--              <img src="images/2-Website-Change-Password.png" alt="" class="img-responsive"> -->
                         <img src="{{asset('public/forntEndAssets/images/2-Website-Change-Password.png')}}" class="img-responsive" />
                        <img src="{{asset('public/forntEndAssets/images/login-city1.png')}}" alt="">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 right-side-new">
                        <img src="{{asset('public/forntEndAssets/images/login-logo.png')}}" alt="" class="img-responsive">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <h3><span>Enter Mail Id</span></h3>
                        </div>
                        <form method="post" action="{{URL::to('sendemail')}}" class="login-form-part">
                            @csrf
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form" placeholder="Enter Your mail Id" name="email" /><!-- <i class="far fa-envelope"></i> -->
                            </div>    
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <button type="submit" class=" btn-login">Submit</button> 
                            </div>
                            
                        </form>
                       <div class="back-button"><a href="{{URL::to('/agent')}}"><i class="fas fa-long-arrow-alt-left"></i></a></div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
        
            


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


    </body>
</html>      