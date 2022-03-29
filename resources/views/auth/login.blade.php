<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> culturetru</title>   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">  
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;200;300;400;500&display=swap" rel="stylesheet">

    <!-- App css -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" />
    <style> 
        body, .btn {
            font-family: 'Prompt', sans-serif;  
            font-weight: 300;
        }  
        .bg-main {   
          background-color: #fff;
          background: url("{{ asset('images/pikul-white.png') }}") repeat, #662c81;
          -webkit-text-size-adjust: 100%;
          -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }
        strong {
          font-weight: 400;
        } 
    </style> 
</head>

<body class="authentication-bg bg-main authentication-bg-pattern d-flex align-items-center pb-0 vh-100">   
    <div class="account-pages w-100 mt-5 mb-5">
        <div class="container"> 
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mb-0"> 
                        <div class="card-body p-4"> 
                            <div class="account-box">
                                <div class="account-logo-box">    
                                  <h5 class="text-uppercase mb-0">ทำการล็อกอินเข้าสู่ระบบ</h5> 
                                </div>
                                @if(session("error"))
                                  <div class="alert alert-danger text-danger mt-2" role="alert" style="background: #fff2f1;"> 
                                      {{session("error")}} 
                                  </div> 
                                @endif 
                                @if(session("success"))
                                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                                    <i class="icon-check"></i> {{session("success")}} 
                                  </div> 
                                @endif 

                                <div class="account-content mt-2">
                                    <form class="form-horizontal" action="{{ route('login-check') }}" method="POST"> 
                                    @csrf
                                        <div class="form-group row">
                                          <div class="col-12">
                                            <label for="email">อีเมล</label>
                                            <input class="form-control form-control-lg" type="email" id="email" name="email" required="" placeholder="โปรดระบุอีเมลของท่าน" required
                                            value="{{ old('email') }}">
                                            @error('email')
                                              <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                          </div>
                                        </div>

                                        <div class="form-group row">
                                          <div class="col-12">
                                            <a href="{{ route('forget.password.get') }}" class="text-muted float-right"><small>ลืมรหัสผ่าน ?</small></a>
                                            <label for="password">รหัสผ่าน</label>
                                            <input class="form-control form-control-lg" type="password" required="" id="password" name="password" placeholder="โปรดระบุรหัสผ่านของท่าน" required>
                                            @error('password')
                                              <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                          </div>
                                        </div> 
                                        <div class="form-group row text-center">
                                          <div class="col-12">
                                            <button class="btn btn-md btn-block btn-primary waves-effect waves-light btn-lg" type="submit">
                                              <span class="text-submit">ล็อกอิน</span>
                                            </button>
                                          </div>
                                        </div> 
                                    </form>  
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
        </div> 
    </div> 
  </div> 
    <script src="{{ asset('admin/js/vendor.min.js') }}"></script> 
    <script src="{{ asset('admin/js/app.min.js') }}"></script> 
    <script>  
      $( "form" ).submit(function( event ) { 
        $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
        $( "form" ).submit();  
      }); 
    </script>
</body>
 
</html>