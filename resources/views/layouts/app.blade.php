<!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        <title> สำนักศิลปะและวัฒนธรรม: ติดต่อเรา </title>   
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}"> 
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@200;300;400;500;600&display=swap" rel="stylesheet">

        <!-- App css -->
        <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" />
        <style> 
            body, .btn {
                font-family: 'Bai Jamjuree', sans-serif;
                font-size: 14px;
                font-weight: 400;
            } 
            iframe {width: 80%; height: 700px;}
            .nav-second-level li a:focus, .nav-second-level li a:hover, .nav-thrid-level li a:focus, .nav-thrid-level li a:hover {
                color: #ddd;
            }
            .nav-second-level li.mm-active>a, .nav-third-level li.mm-active>a {
                color: #95549E;
            }
            .logo-box {background-color: #95549E;}
            .card-header {
                padding: 1rem 1.5rem;
                margin-bottom: 0;
                background-color: #FFF;
                border-bottom: 1px solid #f3f3f3;
            }
             
            .btn { border-radius: 0;}
            .structure-emy{
                background: #95549E;
                color: #FFF;
                padding: 0.5rem 1rem;
            }
            .table td, .table th {
                font-weight: 400;
                padding: 0.5rem;
                vertical-align: middle;
            }
            thead {
                background: #95549E;
                color: #fff;
            }
            a { font-weight: 300;}
            a:hover {
                color: #e3b7e9;
                text-decoration: none;
            }
            .badge {
                color: #fff;
                font-family: 'Prompt', sans-serif;
                font-weight: 400;
                font-size: 11px;
                border-radius: 0;
                padding: 0.49rem;
            } 

            /* ==== REDIO ==== */ 
            input:disabled {
                cursor: default;
                background: #ddd;
                border-color: rgba(118, 118, 118, 0.3);
            } 
            .cc-selector input{
                margin: 0;
                padding: 0;
                -webkit-appearance:none;
                -moz-appearance:none;
                appearance:none;
            } 
            .cc-selector-2 input{
                position:absolute;
                z-index:999;
            } 
            .cc-selector-2 input:active +.drinkcard-cc, .cc-selector input:active +.drinkcard-cc{opacity: .9;}
            .cc-selector-2 input:checked +.drinkcard-cc, .cc-selector input:checked +.drinkcard-cc{
                -webkit-filter: none;
                -moz-filter: none;
                filter: none;
            }
            .drinkcard-cc{
                font-weight: 200;
                cursor:pointer;
                background-size:contain;
                background-repeat:no-repeat;
                display:inline-block; 
                -webkit-transition: all 100ms ease-in;
                -moz-transition: all 100ms ease-in;
                transition: all 100ms ease-in;
                -webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
                -moz-filter: brightness(1.8) grayscale(1) opacity(.7);
                filter: brightness(1.8) grayscale(1) opacity(.7);
                padding: 0.7rem;
                background: #ddd;
                color: #FFF; 
            }
            .drinkcard-cc:hover{
                -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
                -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
                filter: brightness(1.2) grayscale(.5) opacity(.9);
            } 
            /* ==== REDIO ==== */ 
            .dtr-details {width: 100%;}
            a.text-primary:focus, a.text-primary:hover {
                color: #0e436d!important;
            }
            ::-webkit-scrollbar {
                height: 0;
            }
            ::-webkit-scrollbar {
                width: 4px;
                height: 4px;
            }
            ::-webkit-scrollbar-thumb {
                background: #95549e73;
                border-radius: 1rem;
            }
            ::-webkit-scrollbar-track {
                background: #95549e2b;
            }
            .navbar-custom {z-index: 1040;}
        </style>
        @yield('style')
    </head>

    <body>
 
        <div id="wrapper"> 
            <div class="navbar-custom">
                @guest 
                @else 
                   <ul class="list-unstyled topnav-menu float-right mb-0">    
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('images/icon/no-users.png') }}" alt="user-image" class="rounded-circle" style="background: #fad7ff;">
                                <span class="pro-user-name ml-1"> 
                                    {{ Auth::user()->name }}   <i class="mdi mdi-chevron-down"></i> 
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                
                                <div class="dropdown-header noti-title"> 
                                    <h6 class="text-overflow m-0"> ยินดีต้อนรับเข้าสู่ระบบ </h6>
                                </div>  
                                 
                                <a href="{{ route('profile') }}" class="dropdown-item notify-item">
                                    <i class="fe-settings"></i>
                                    <span>ตั้งค่าข้อมูลส่วนตัว</span>
                                </a> 

                                <div class="dropdown-divider"></div>  
                                <a href="#" class="dropdown-item notify-item" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="fe-log-out"></i>
                                    <span>ออกจากระบบ</span>
                                </a> 
                                <form id="logout-form" action="{{ route('signOut') }}" method="POST" class="d-none">
                                    @csrf
                                </form> 
                            </div>
                        </li> 
                   </ul> 
                @endguest
 
                <div class="logo-box">
                    <a href="{{ route('home') }}" class="logo text-center">
                      <span class="logo-lg"> 
                        <span class="logo-lg-text-light">
                          <img src="{{ asset('images/pikul-white.png') }}" height="30" class="rounded-circle avatar-sm">    
                          culturetru
                        </span>
                      </span>
                      <span class="logo-sm">
                        <img src="{{ asset('images/pikul-white.png') }}" height="30">
                      </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                  <li>
                    <button class="button-menu-mobile waves-effect waves-light">
                        <i class="fe-menu"></i>
                    </button>
                  </li> 
                </ul>
            </div>
            
            <div class="left-side-menu"> 
                <div class="slimscroll-menu"> 
                    <div id="sidebar-menu"> 
                        <ul class="metismenu" id="side-menu"> 
                            <li class="menu-title"> จัดการข้อมูล </li>  
                            <li>
                                <a href="{{ route('home') }}">
                                    <i class="fe-airplay"></i> 
                                    <span> หน้าหลัก </span> 
                                </a>
                            </li>  
                            <li>
                                <a href="{{ route('news.list') }}">
                                    <i class="dripicons-broadcast"></i> 
                                    <span> ข่าวประชาสัมพันธ์ </span> 
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('activity.list') }}">
                                    <i class="dripicons-calendar"></i> 
                                    <span> โครงการ/กิจกรรม </span> 
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('acticonservation.list') }}">
                                    <i class="fe-layers"></i> 
                                    <span> กิจกรรมหน่วยอนุรักษ์ฯ</span> 
                                </a>
                            </li> 
                            <li>
                                <a href="{{ route('research.list') }}">
                                    <i class="fe-file-text"></i> 
                                    <span> งานวิจัยและบทความ </span> 
                                </a>
                            </li>   
                            <li>
                                <a href="{{ route('book.list') }}">
                                    <i class="fe-book"></i> 
                                    <span> หนังสือและวารสารสำนัก </span> 
                                </a>
                            </li> 
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe-box"></i> 
                                    <span> แหล่งเรียนรู้ </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false"> 
                                    <li> <a href="{{ route('learning.list') }}"> แหล่งเรียนรู้ </a></li>
                                    <li> <a href="{{ route('learningcategory.list') }}"> ประเภทแหล่งเรียนรู้ </a></li>  
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('journal.list') }}">
                                    <i class="fe-folder"></i> 
                                    <span> จดหมายข่าว  </span> 
                                </a>
                            </li>   
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe-layout"></i> 
                                    <span> แก้ไขหน้าเว็บไซต์ </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false"> 
                                    <li> 
                                        <a href="javascript: void(0);"> 
                                            <span> แนะนำหน่วยงาน </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false"> 
                                            <li> <a href="{{ route('pagesedit', [1]) }}"> ประวัติความเป็นมา </a></li>
                                            <li> <a href="{{ route('pagesedit', [2]) }}"> ปรัชญา วิสัยทัศน์ พันธกิจ </a></li>
                                            <li> <a href="{{ route('pagesedit', [3]) }}"> ตราสัญลักษณ์ </a></li>
                                            <li> <a href="{{ route('pagesedit', [4]) }}"> นโยบายและแผนยุทธศาสตร์ </a></li>
                                            <li> <a href="{{ route('network.list') }}"> เครือข่ายความร่วมมือ </a></li>
                                            <li> <a href="{{ route('annual.list') }}"> ประกันคุณภาพการศึกษา/รายงานประจำปี </a></li> 
                                        </ul>
                                    </li> 
                                    <li> 
                                        <a href="javascript: void(0);"> 
                                            <span> การบริหาร </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false"> 
                                            <li> <a href="{{ route('pagesedit', [7]) }}"> โครงสร้างองค์กร </a></li>
                                            <li> <a href="{{ route('pagesedit', [8]) }}"> คณะกรรมการประจำสำนัก </a></li>
                                            <li> <a href="{{ route('pagesedit', [9]) }}"> ทำเนียบผู้บริหาร </a></li>
                                            <li> <a href="{{ route('pagesedit', [10]) }}"> บุคลากร </a></li> 
                                        </ul>
                                    </li> 
                                    <li> 
                                        <a href="javascript: void(0);"> 
                                            <span> หน่วยอนุรักษ์ฯจังหวัดลพบุรี </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false"> 
                                            <li> <a href="{{ route('pagesedit', [11]) }}"> ความเป็นมา </a></li>
                                            <li> <a href="{{ route('pagesedit', [12]) }}"> บทบาทหน้าที่ </a></li>
                                            <li> <a href="{{ route('pagesedit', [13]) }}"> คณะกรรมการ </a></li> 
                                        </ul>
                                    </li>  
                                    <li> <a href="{{ route('pagesedit', [14]) }}"> ติดต่อเรา </a></li> 
                                    <li> <a href="{{ route('slideshow.list') }}"> รูปสไลด์ </a></li> 
                                </ul>
                            </li>
                            <hr>
                            <li>
                                <a href="{{ route('roles.list') }}">
                                    <i class="fe-users"></i> 
                                    <span> ผู้เข้าใช้งานระบบ </span> 
                                </a>
                            </li> 
                        </ul> 
                    </div> 
                    <div class="clearfix"></div> 
                </div> 
            </div> 

            <div class="content-page"> 
                @yield('content')   
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                2022 - {{date('Y')}} &copy; culturetru | ระบบจัดการข้อมูล สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี
                            </div>
                        </div>
                    </div>
                </footer> 
            </div> 
        </div>  
        <script src="{{ asset('admin/js/vendor.min.js') }}"></script> 
        <script src="{{ asset('admin/js/app.min.js') }}"></script> 
        @yield('script')
    </body>
</html>