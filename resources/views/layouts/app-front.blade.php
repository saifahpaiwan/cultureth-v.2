<!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        
        <!-- Primary Meta Tags -->
        <title> สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี</title>
        @yield('meta') 

        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}"> 
        <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@200;300;400;500;600&display=swap" rel="stylesheet">

        <!-- App css -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" 
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> 
        <style> 
            body, .btn {
                font-family: 'Bai Jamjuree', sans-serif;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.5;
                background-color: #fff;
                background: url('{{ asset("images/pikul-white.png") }}') repeat, #D5C5D8;
                -webkit-text-size-adjust: 100%;
                -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            }   
            .logo {height: 40px;}
            .nav-title { 
                line-height: 1;
                color: #7d7020;
                font-weight: 500;
            }
            .font-13 {font-size: 13px;}
            footer {
                background: #463A48;
                color: white;
                min-height: 150px;
                font-family: "Bai Jamjuree", sans-serif;
            }
            footer h3 {
                font-size: 1rem;
                text-align: center; 
                padding-bottom: 0.5rem;
                border-bottom: solid 0.5px #ffc107;
            }
            footer li a {
                color: #f8f9fa !important;
                text-decoration: none !important;
            }
             
            .carousel-inner {
                max-height: 400px;
            }
            .title-content {
                font-weight: 600;
                color: #6f42c1;
            }
            .white-space-normal-1 { 
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .white-space-normal {
                line-height: 1.5em;
                height: 44px;
                width: 100%;
                white-space: normal;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .hero {
                height: 250px;
                text-align: center;
                color: #f8f9fa;
                font-family: "Bai Jamjuree", sans-serif;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .btn {background: #d5c5d8; padding: 0.49rem 0.75rem;}
            .hero {
                background: -webkit-gradient(linear, left top, left bottom, from(rgba(69, 57, 71, 0.7)), to(rgba(69, 57, 71, 0.9))), url("{{ asset('images/hero.jpg') }}") center/cover repeat;
                background: linear-gradient(rgba(69, 57, 71, 0.7), rgba(69, 57, 71, 0.9)), url("{{ asset('images/hero.jpg') }}") center/cover repeat;
            }
            .hero .hero-texts {
                position: relative;
                top: 50%;
                -webkit-transform: translateY(-50%);
                transform: translateY(-50%);
            }
            .content-file table{ width: 100%; }    
            .box-filter {
                background: #ddd;
                padding: 1.5rem 1rem;
            }
            b {color: #95549E;}
            section {background: #f8f9fa;}
            .box-list {
                border: 1px solid #ddd;
                background: #fff;
                border-radius: 0.25rem;
                box-shadow: 2px 2px 5px #ddd;
            }
            a {
                color: #212529;
                text-decoration: inherit;
                background-color: transparent;
            }
            a:hover {
                color: #727272;
                text-decoration: inherit;
            }
            .img-carousel-o {
                height: 400px; 
                background-position: center; 
                background-size: cover;
            }
            .modal-close-01 {
                font-size: 30px;
                border-radius: 1.25rem;
                position: absolute;
                right: -10px;
                top: -15px;
            }
            iframe, object {width: 90%; height: 700px;} 
            @media (max-width: 600px){
                .img-carousel-o { height: 130px; }
                iframe, object {width: 100%; height: 500px;} 
            }
        </style>
        @yield('style')
    </head> 
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light"> 
            <a class="navbar-brand" href="{{ route('index') }}">
                <div class="d-flex"> 
                    <img src="{{ asset('images/logo.png') }}" class="logo">
                    <div class="ml-2 mt-1 text-center nav-title"> 
                        <div >สำนักศิลปะและวัฒนธรรม</div>
                        <div class="font-13">มหาวิทยาลัยราชภัฏเทพสตรี</div>
                    </div>
                </div>
            </a> 
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> 
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto"> 
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                            แนะนำหน่วยงาน
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('about.history') }}">ประวัติความเป็นมา</a>
                            <a class="dropdown-item" href="{{ route('about.vision') }}">ปรัชญา วิสัยทัศน์ พันธกิจ</a>
                            <a class="dropdown-item" href="{{ route('about.symbol') }}">ตราสัญลักษณ์</a>
                            <a class="dropdown-item" href="{{ route('about.policy') }}">นโยบายและแผนยุทธศาสตร์</a>
                            <a class="dropdown-item" href="{{ route('cooperationnetwork') }}">เครือข่ายความร่วมมือ</a>
                            <a class="dropdown-item" href="{{ route('reportannual') }}">รายงานประจำปี</a> 
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                            การบริหาร
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">    
                            <a class="dropdown-item" href="{{ route('admin.structure') }}">โครงสร้างองค์กร</a>
                            <a class="dropdown-item" href="{{ route('admin.executive') }}">ทำเนียบผู้บริหาร</a>
                            <a class="dropdown-item" href="{{ route('admin.commitee') }}">คณะกรรมการประจำสำนัก</a> 
                            <a class="dropdown-item" href="{{ route('admin.personel') }}">บุคลากร</a> 
                        </div>
                    </li> 
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                            ฐานข้อมูลศิลปะและวัฒนธรรม
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('book') }}">หนังสือและวารสารสำนักฯ</a>
                            <a class="dropdown-item" href="{{ route('research') }}">งานวิจัยและบทความ</a>
                            <a class="dropdown-item" href="{{ route('learning') }}">แหล่งเรียนรู้</a> 
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                            หน่วยอนุรักษ์ฯจังหวัดลพบุรี
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('preserve.history') }}">ความเป็นมา</a>
                            <a class="dropdown-item" href="{{ route('preserve.duties') }}">บทบาทหน้าที่</a>
                            <a class="dropdown-item" href="{{ route('preserve.committee') }}">คณะกรรมการ</a>
                            <a class="dropdown-item" href="{{ route('acticonservation') }}">กิจกรรมหน่วยอนุรักษ์ฯ</a> 
                            <a class="dropdown-item" href="https://culturalenvi.onep.go.th/site?&province=7">ฐานข้อมูลหน่วยอนุรักษ์ฯ</a> 
                        </div>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('journal') }}">จดหมายข่าว</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('news') }}">ข่าวประชาสัมพันธ์</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">ติดต่อเรา</a>
                    </li> 
                </ul> 
            </div>
        </nav>
        @yield('content')   
        <footer>
            <div class="container-fluid">
                <div class="row p-5">
                    <div class="col-12 col-sm-4">
                        <h3>หน่วยงานภายใน</h3>
                        <ul>
                            <li>
                                <a href="https://reg.tru.ac.th/registrar/home.asp" target="_blank">มหาวิทยาลัยราชภัฏเทพสตรี</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-4">
                        <h3>หน่วยงานภายนอก</h3>
                        <ul>
                            <li>
                                <a href="https://www.m-culture.go.th/lopburi/main.php?filename=index" target="_blank">สำนักงานวัฒนธรรมจังหวัดลพบุรี</a>
                            </li>
                            <li>
                                <a href="https://www.mhesi.go.th/" target="_blank">กระทรวงการอุดมศึกษา วิทยาศาสตร์ วิจัยและนวัตกรรม</a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/CAC.RUT" target="_blank">สภาศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏแห่งประเทศไทย</a>
                            </li> 
                        </ul>
                    </div>
                    <div class="col-12 col-sm-4">
                        <h3>เว็บไซต์ที่เกี่ยวข้อง</h3>
                        <ul>
                            <li>
                                <a href="http://website2021.lopburi.go.th/" target="_blank">จังหวัดลพบุรี</a>
                            </li>
                            <li>
                                <a href="https://www.lopburi.org/culture-lopburi" target="_blank">เที่ยวเชิงวัฒนธรรม จังหวัดลพบุรี</a>
                            </li>
                        </ul>
                    </div>
                </div> 
            </div>
            <div class="p-1 text-center" style="background: #5a4c5d; color: #FFF; font-size: 12px;">  
                2022 &copy; สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี   
                <a  target="_blank" style="color: #FFF; font-weight: 500;" href="{{ route('login') }}"> <i class="fe-log-in"></i> เข้าสู่ระบบ</as>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
        @yield('script')
    </body>
</html>