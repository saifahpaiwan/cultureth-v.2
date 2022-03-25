@extends('layouts.app-front')
@section('meta')  
    <meta name="title" content=" สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี">
    <meta name="description" content="มหาวิทยาลัยราชภัฏเทพสตรี ตำบลทะเลชุบศร อำเภอเมือง จังหวัดลพบุรี 15000  
    เบอร์โทรศัพท์ 036 - 413096 อีเมล์ culturetru@gmail.com">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('index') }}">
    <meta property="og:title" content=" สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี">
    <meta property="og:description" content="มหาวิทยาลัยราชภัฏเทพสตรี ตำบลทะเลชุบศร อำเภอเมือง จังหวัดลพบุรี 15000  
    เบอร์โทรศัพท์ 036 - 413096 อีเมล์ culturetru@gmail.com">
    <meta property="og:image" content="{{ asset('images/meta_img.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('index') }}">
    <meta property="twitter:title" content=" สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี">
    <meta property="twitter:description" content="มหาวิทยาลัยราชภัฏเทพสตรี ตำบลทะเลชุบศร อำเภอเมือง จังหวัดลพบุรี 15000  
    เบอร์โทรศัพท์ 036 - 413096 อีเมล์ culturetru@gmail.com">
    <meta property="twitter:image" content="{{ asset('images/meta_img.png') }}">
@endsection
@section('style')   
<style>  
</style> 
@endsection
@section('content')
    <div class="container bg-white">  
        <div id="carousel-1" class="carousel slide" data-ride="carousel"> 
            <ol class="carousel-indicators">
                @if(isset($data['Query_slideshow']))
                    @if(count($data['Query_slideshow'])>0)
                        <?php $index=0; ?>
                        @foreach($data['Query_slideshow'] as $row)
                            @if($row->slide_type==1)
                                <li data-target="#carousel-1" data-slide-to="{{ $index }}" class="@if($index==0) {{ __('active') }} @endif"></li> 
                                <?php $index++; ?> 
                            @endif
                        @endforeach
                    @endif
                @endif  
            </ol>
            <div class="carousel-inner">
                @if(isset($data['Query_slideshow']))
                    @if(count($data['Query_slideshow'])>0)
                        <?php $index2=0; ?>
                        @foreach($data['Query_slideshow'] as $row)
                            @if($row->slide_type==1)  
                                <div class="carousel-item img-carousel-o @if($index2==0) {{ __('active') }} @endif" style="background-image: url({{ asset('images/slideshow').'/'.$row->image_desktop }});">
                                    <a href="@if(!empty($row->link)) {{$row->link}} @else {{ __('#') }} @endif">
                                        <div class="carousel-caption d-none d-md-block">
                                            <p style="text-shadow: 2px 2px 5px #000;">{{ $row->title }}</p>
                                        </div>
                                    </a>
                                </div> 
                                <?php $index2++; ?> 
                            @endif
                        @endforeach
                    @endif
                @endif  
            </div>
            <a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-1" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="row pt-2 pb-2 px-md-5"> 
            <div class="col-md-6"> 
                <div class="d-flex mt-2 mb-2">
                    <h5 class="mr-auto">โครงการ/กิจกรรม</h5>
                    <a href="{{ route('activity') }}" class="btn all"> ทั้งหมด </a>  
                </div> 
                @if(isset($data['Query_activity']))
                    @if(count($data['Query_activity'])>0)
                        @foreach($data['Query_activity'] as $row)
                            <a href="{{ route('activity.view', [$row->id]) }}">
                                <div class="row mt-2"> 
                                    <div class="col-4 col-sm-3 pr-0"> 
                                        <img src="{{ asset('images/activity').'/'.$row->activity_image_desktop }}" class="img-fluid rounded" alt="">  
                                    </div>
                                    <div class="col-8 col-sm-9"> 
                                        <div class="title-content white-space-normal-1">
                                            {{ $row->activity_intro }}
                                        </div>   
                                        <div class="white-space-normal"> {{ $row->activity_intro }} </div> 
                                        <div class="d-flex"> 
                                            <div class="mr-auto font-13"> <i class="fe-calendar"></i> {{ date("d/m/Y", strtotime($row->created_at)) }} </div>
                                            อ่านเพิ่มเติม  
                                        </div> 
                                    </div>  
                                </div>
                            </a>
                        @endforeach
                    @endif
                @endif
            </div> 
            <div class="col-md-6"> 
                <div class="d-flex mt-2 mb-2">
                    <h5 class="mr-auto">กิจกรรมหน่วยอนุรักษ์ฯ</h5>
                    <a href="{{ route('acticonservation') }}" class="btn all"> ทั้งหมด </a>  
                </div>
                @if(isset($data['Query_conservation']))
                    @if(count($data['Query_conservation'])>0)
                        @foreach($data['Query_conservation'] as $row)
                            <a href="{{ route('acticonservation.view', [$row->id]) }}">
                                <div class="row mt-2"> 
                                    <div class="col-4 col-sm-3 pr-0"> 
                                        <img src="{{ asset('images/acticonservation').'/'.$row->acticonservation_image_desktop }}" class="img-fluid rounded" alt="">  
                                    </div>
                                    <div class="col-8 col-sm-9"> 
                                        <div class="title-content white-space-normal-1">
                                            {{ $row->acticonservation_intro }}
                                        </div>   
                                        <div class="white-space-normal"> {{ $row->acticonservation_intro }} </div> 
                                        <div class="d-flex"> 
                                            <div class="mr-auto font-13"> <i class="fe-calendar"></i> {{ date("d/m/Y", strtotime($row->created_at)) }} </div>
                                            อ่านเพิ่มเติม  
                                        </div> 
                                    </div>  
                                </div>
                            </a>
                        @endforeach
                    @endif
                @endif
            </div> 
        </div>
        <div class="row pt-2 pb-2 px-md-5">  
            <div class="col-md-6">
                <div class="row"> 
                    <div class="col-md-12"> 
                        <div class="d-flex mt-2 mb-2">
                            <h5 class="mr-auto">หนังสืออิเล็กทรอนิกส์</h5>
                            <a href="{{ route('book') }}" class="btn all"> ทั้งหมด </a>  
                        </div>
                    </div>
                    @if(isset($data['Query_book']))
                            @if(count($data['Query_book'])>0)
                                @foreach($data['Query_book'] as $row)
                                    <div class="col-md-4 p-1"> 
                                        <a href="{{ route('book.view', [$row->id]) }}">
                                            <div class="card mb-2">
                                                <img class="card-img-top" src="{{ asset('images/book').'/'.$row->book_image_desktop }}" alt="Card image cap">
                                                <div class="card-body p-1">
                                                    <div class="white-space-normal-1"> {{ $row->book_title }} </div>
                                                    <p class="card-text white-space-normal">{{ $row->book_keyword }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-md-6"> 
                <div class="row"> 
                    <div class="col-md-12"> 
                        <div class="d-flex mt-2 mb-2">
                            <h5 class="mr-auto">งานวิจัยและบทความ</h5>
                            <a href="{{ route('research') }}" class="btn all"> ทั้งหมด </a>  
                        </div>
                    </div>
                    @if(isset($data['Query_research']))
                            @if(count($data['Query_research'])>0)
                                @foreach($data['Query_research'] as $row)
                                    <div class="col-md-4 p-1"> 
                                        <a href="{{ route('research.view', [$row->id]) }}">
                                            <div class="card mb-2">
                                                <img class="card-img-top" src="{{ asset('images/research').'/'.$row->research_image_desktop }}" alt="Card image cap">
                                                <div class="card-body p-1">
                                                    <div class="white-space-normal-1"> {{ $row->research_title }} </div>
                                                    <p class="card-text white-space-normal">{{ $row->research_keyword }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div> 
        <div class="row pt-5 pb-2 px-md-5"> 
            <div class="col-md-8 pb-2"> 
                <div class="d-flex">
                    <h5 class="mr-auto">ข่าวประชาสัมพันธ์</h5>
                    <a href="{{ route('news') }}" class="btn all"> ทั้งหมด </a>  
                </div>
                @if(isset($data['Query_news']))
                    @if(count($data['Query_news'])>0)
                        @foreach($data['Query_news'] as $row)
                            <a href="{{ route('news.view', [$row->id]) }}">
                                <div class="row mt-2"> 
                                    <div class="col-4 col-sm-3 pr-0"> 
                                        <img src="{{ asset('images/news').'/'.$row->news_image_desktop }}" class="img-fluid rounded" alt="">  
                                    </div>
                                    <div class="col-8 col-sm-9"> 
                                        <div class="title-content white-space-normal">
                                            {{ $row->news_title }}
                                        </div>   
                                        <div class="white-space-normal">{{ $row->news_intro }}</div> 
                                        <div class="d-flex"> 
                                            <div class="mr-auto font-13"> <i class="fe-calendar"></i> {{ date("d/m/Y", strtotime($row->created_at)) }} </div>
                                            อ่านเพิ่มเติม  
                                        </div> 
                                    </div>  
                                </div>
                            </a>
                        @endforeach
                    @endif
                @endif
            </div> 
            <div class="col-md-4 text-center"> 
                <div class="fb-page" data-href="https://web.facebook.com/artcultureTRU99/?_rdc=1&amp;_rdr" data-tabs="timeline" data-width="340" data-height="450" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://web.facebook.com/artcultureTRU99/?_rdc=1&amp;_rdr" class="fb-xfbml-parse-ignore">
                        <a href="https://web.facebook.com/artcultureTRU99/?_rdc=1&amp;_rdr">สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี</a>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="row p-4" style="background: #ddd;"> 
            <div class="col-md-12"> 
                <h5> สื่อวิดิทัศน์ </h5>
                <div id="carousel-2" class="carousel slide mb-4" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @if(isset($data['Query_slideshow']))
                            @if(count($data['Query_slideshow'])>0)
                                <?php $index=0; ?>
                                @foreach($data['Query_slideshow'] as $row)
                                    @if($row->slide_type==2)
                                        <li data-target="#carousel-2" data-slide-to="{{ $index }}" class="@if($index==0) {{ __('active') }} @endif"></li> 
                                        <?php $index++; ?> 
                                    @endif
                                @endforeach
                            @endif
                        @endif  
                    </ol>
                    <div class="carousel-inner">
                        @if(isset($data['Query_slideshow']))
                            @if(count($data['Query_slideshow'])>0)
                                <?php $index2=0; ?>
                                @foreach($data['Query_slideshow'] as $row)
                                    @if($row->slide_type==2) 
                                        <div class="carousel-item img-carousel-o @if($index2==0) {{ __('active') }} @endif" style="background-image: url({{ asset('images/slideshow').'/'.$row->image_desktop }});">
                                            <a href="@if(!empty($row->link)) {{$row->link}} @else {{ __('#') }} @endif">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <p style="text-shadow: 2px 2px 5px #000;">{{ $row->title }}</p>
                                                </div>
                                            </a>
                                        </div> 
                                        <?php $index2++; ?> 
                                    @endif
                                @endforeach
                            @endif
                        @endif  
                    </div>
                    <a class="carousel-control-prev" href="#carousel-2" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-2" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div> 
        </div> 
    </div>
@endsection
@section('script')  
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v13.0" nonce="JRKdkS0F"></script>  
<script> 
 
</script>
@endsection

