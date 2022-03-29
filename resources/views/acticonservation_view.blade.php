@extends('layouts.app-front')
@section('meta')  
    <meta name="title" content=" @if(isset($data['result']->acticonservation_meta_title)) {{ $data['result']->acticonservation_meta_title }} @endif">
    <meta name="description" content="@if(isset($data['result']->acticonservation_meta_description)) {{ $data['result']->acticonservation_meta_description }} @endif">
    <meta name="keywords" content="@if(isset($data['result']->acticonservation_meta_keyword)) {{ $data['result']->acticonservation_meta_keyword }} @endif">
    
    <!-- Open Graph / Faceacticonservation -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('acticonservation.view', [$data['get_id']]) }}">
    <meta property="og:title" content=" @if(isset($data['result']->acticonservation_meta_title)) {{ $data['result']->acticonservation_meta_title }} @endif">
    <meta property="og:description" content="@if(isset($data['result']->acticonservation_meta_description)) {{ $data['result']->acticonservation_meta_description }} @endif">
    <meta property="og:keywords" content="@if(isset($data['result']->acticonservation_meta_keyword)) {{ $data['result']->acticonservation_meta_keyword }} @endif">
    <meta property="og:image" content="@if(isset($data['result']->acticonservation_image_thumb_desktop)) {{ asset('images/acticonservation').'/'.$data['result']->acticonservation_image_thumb_desktop }} @endif ">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('acticonservation.view', [$data['get_id']]) }}">
    <meta property="twitter:title" content=" @if(isset($data['result']->acticonservation_meta_title)) {{ $data['result']->acticonservation_meta_title }} @endif">
    <meta property="twitter:description" content="@if(isset($data['result']->acticonservation_meta_description)) {{ $data['result']->acticonservation_meta_description }} @endif">
    <meta property="twitter:keywords" content="@if(isset($data['result']->acticonservation_meta_keywords)) {{ $data['result']->acticonservation_meta_keywords }} @endif">
    <meta property="twitter:image" content="@if(isset($data['result']->acticonservation_image_thumb_desktop)) {{ asset('images/acticonservation').'/'.$data['result']->acticonservation_image_thumb_desktop }} @endif">
@endsection
@section('style')   
<style>   
    .hero {
        background: -webkit-gradient(linear, left top, left bottom, from(rgba(69, 57, 71, 0.7)), to(rgba(69, 57, 71, 0.9))), url("{{ asset('images/hero5.jpg') }}") center/cover repeat;
        background: linear-gradient(rgba(69, 57, 71, 0.7), rgba(69, 57, 71, 0.9)), url("{{ asset('images/hero5.jpg') }}") center/cover repeat;
    }
    .hero .hero-texts {
        position: relative;
        top: 50%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }
</style> 
@endsection
@section('content') 
    <div class="container bg-white">  
        <section class="hero">
            <div class="hero-texts">
                <h1 class="display-4"> กิจกรรมหน่วยอนุรักษ์ฯ </h1>  
            </div>
        </section>
        <section class=""> 
            <div class="row p-3 px-md-5">   
                <div class="col-md-12"> 
                    <h4 class=""> {{ $data['result']->acticonservation_title }} </h4>
                    <div class="mb-2"> {{ $data['result']->acticonservation_intro }} </div>
                    <div class="font-13 mb-2"> <i class="fe-calendar"></i> {{ date("d/m/Y", strtotime($data['result']->created_at)) }} </div>
                    <div class="d-flex"> 
                        <div class="sharethis-inline-share-buttons" style="height: 0;"></div> 
                        <a href="{{ route('acticonservation') }}" class="btn ml-5"> ย้อนกลับ </a>  
                    </div>
                </div>
            </div>
            <hr>
            <div class="row p-3 px-md-5">  
                <div class="col-md-12 pb-4">  
                    @if(isset($data['result']->file_pdf))
                        @if(!empty($data['result']->file_pdf))
                            <div class="text-center mb-3">  
                                <object data="{{ asset('images/acticonservation/pdf').'/'.$data['result']->file_pdf }}" type="application/pdf" width="100%" height="100%">
                                    <div><b>เบราว์เซอร์นี้ไม่สนับสนุน PDF กรุณาดาวน์โหลดไฟล์ PDF เพื่อดู</b> </div>
                                    <a class="btn mt-1" href="{{ asset('images/acticonservation/pdf').'/'.$data['result']->file_pdf }}">Download PDF</a>  
                                </object>
                            </div> 
                        @endif
                    @endif
                    <?php 
                        if(isset($data['result']->acticonservation_file_text)){
                            echo file_get_contents(storage_path().'/app/'.$data['result']->acticonservation_file_text); 
                        }
                    ?> 
                </div>
                <div class="col-md-12 pb-4">
                    @if(isset($data['acticonservation_gallery']))
                        @if(count($data['acticonservation_gallery'])>0)
                            <div class="row">
                                @foreach($data['acticonservation_gallery'] as $row) 
                                    <div class="col-md-2 p-1">
                                        <a href="javascript: void(0);" class="galleries-click" data-img="{{ asset('images/acticonservation/galleries').'/'.$row->image }}">
                                            <img src="{{ asset('images/acticonservation/galleries').'/'.$row->image }}" style="width: 100%;"> 
                                        </a>
                                    </div>
                                @endforeach
                            </div> 
                        @endif 
                    @endif  
                </div>
            </div> 
        </section> 
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-galleries" tabindex="-1" role="dialog" aria-labelledby="modal-galleriesTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"> 
                <div class="modal-body">
                    <a href="javascript: void(0);" data-dismiss="modal" aria-label="Close" class="modal-close-01"> <i class="mdi mdi-close-circle"></i> </a>
                    <div class="img-galleries"> </div>
                </div> 
            </div>
        </div>
    </div>
@endsection
@section('script')   
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=62335409b947cf001aac6740&product=inline-share-buttons" async="async"></script>
<script>  
    $(document).on('click', '.galleries-click', function(event) { 
        var img=$(this)[0].dataset.img;  
        var htmlimg='<img src="'+img+'" style="width:100%;">';
        $('.img-galleries').html(htmlimg);
        $('#modal-galleries').modal('show');
    });
</script>
@endsection

