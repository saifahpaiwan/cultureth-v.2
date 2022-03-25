@extends('layouts.app-front')
@section('meta')  
    <meta name="title" content=" @if(isset($data['result']->learning_meta_title)) {{ $data['result']->learning_meta_title }} @endif">
    <meta name="description" content="@if(isset($data['result']->learning_meta_description)) {{ $data['result']->learning_meta_description }} @endif">
    <meta name="keywords" content="@if(isset($data['result']->learning_meta_keyword)) {{ $data['result']->learning_meta_keyword }} @endif">
    
    <!-- Open Graph / Facelearning -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('learning.view', [$data['get_id']]) }}">
    <meta property="og:title" content=" @if(isset($data['result']->learning_meta_title)) {{ $data['result']->learning_meta_title }} @endif">
    <meta property="og:description" content="@if(isset($data['result']->learning_meta_description)) {{ $data['result']->learning_meta_description }} @endif">
    <meta property="og:keywords" content="@if(isset($data['result']->learning_meta_keyword)) {{ $data['result']->learning_meta_keyword }} @endif">
    <meta property="og:image" content="@if(isset($data['result']->learning_image_thumb_desktop)) {{ asset('images/learning').'/'.$data['result']->learning_image_thumb_desktop }} @endif ">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('learning.view', [$data['get_id']]) }}">
    <meta property="twitter:title" content=" @if(isset($data['result']->learning_meta_title)) {{ $data['result']->learning_meta_title }} @endif">
    <meta property="twitter:description" content="@if(isset($data['result']->learning_meta_description)) {{ $data['result']->learning_meta_description }} @endif">
    <meta property="twitter:keywords" content="@if(isset($data['result']->learning_meta_keywords)) {{ $data['result']->learning_meta_keywords }} @endif">
    <meta property="twitter:image" content="@if(isset($data['result']->learning_image_thumb_desktop)) {{ asset('images/learning').'/'.$data['result']->learning_image_thumb_desktop }} @endif">
@endsection
@section('style')   
<style>   
    .hero {
        background: -webkit-gradient(linear, left top, left bottom, from(rgba(69, 57, 71, 0.7)), to(rgba(69, 57, 71, 0.9))), url("{{ asset('images/hero3.jpg') }}") center/cover repeat;
        background: linear-gradient(rgba(69, 57, 71, 0.7), rgba(69, 57, 71, 0.9)), url("{{ asset('images/hero3.jpg') }}") center/cover repeat;
    } 
    iframe {
        width: 100%;
        height: 300px;
    }
</style> 
@endsection
@section('content') 
    <div class="container bg-white">  
        <section class="hero">
            <div class="hero-texts">
                <h1 class="display-4"> หนังสือและวารสารสำนักฯ </h1>  
            </div>
        </section>
        <section class=""> 
            <div class="row p-3 px-md-5">  
                <div class="col-md-4"> 
                    <img  src="{{ asset('images/learning').'/'.$data['result']->learning_image_desktop }}" class="img-fluid">
                </div>
                <div class="col-md-8"> 
                    <h4 class=""> {{ $data['result']->learning_title }} </h4>
                    <div class="font-13 mb-2"> <i class="fe-calendar"></i> {{ date("d/m/Y", strtotime($data['result']->created_at)) }} </div>
                    <div class="sharethis-inline-share-buttons mb-3"></div>
                    <div class="mb-2"> <b class="">ประเภทแหล่งเรียนรู้ : </b>	 {{ $data['result']->categories_name }} </div>
                    <div class="mb-2"> <b class="">สถานที่ตั้ง : </b>	 {{ $data['result']->learning_location }} </div>
                    <div class="mb-2"> <b class="">ปี พ.ศ. : </b>     {{ $data['result']->learning_year }} </div>
                    <div class="mb-2"> <b class="">หน่วยงานที่จัดทำ : </b>  {{ $data['result']->learning_publishing_agency }}</div> 

                    <a href="{{ route('learning') }}" class="btn mt-1"> ย้อนกลับ </a> 
                    @if(!empty($data['result']->learning_file_pdf))
                    <a target="_blank" href="{{ asset('images/learning/pdf').'/'.$data['result']->learning_file_pdf }}" class="btn mt-1"> เริ่มอ่าน </a> 
                    @endif
                    @if(!empty($data['result']->link_vdo))
                    <a href="javascript: void(0);" class="btn mt-1 btn-click"> ดู VDO </a> 
                    @endif
                </div>
                <div class="col-md-12"> 
                    <?php 
                        if(isset($data['result']->file_text)){
                            echo '<hr>'.file_get_contents(storage_path().'/app/'.$data['result']->file_text); 
                        }
                    ?> 
                </div>
            </div>
        </section> 
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-vdo" tabindex="-1" role="dialog" aria-labelledby="modal-vdoTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"> 
                <div class="modal-body">
                    <a href="javascript: void(0);" data-dismiss="modal" aria-label="Close" class="modal-close-01"> <i class="mdi mdi-close-circle"></i> </a>
                    <?php 
                        $link="";
                        if(!empty($data['result']->link_vdo)){
                            $explode=explode('https://youtu.be/', $data['result']->link_vdo)[1];
                            $link="https://www.youtube.com/embed/".$explode;
                        }
                    ?>
                    <iframe src="{{ $link }}"  
                    frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
                </div> 
            </div>
        </div>
    </div>
@endsection
@section('script')   
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=62335409b947cf001aac6740&product=inline-share-buttons" async="async"></script>
<script>  
    $(document).on('click', '.btn-click', function(event) {    
        $('#modal-vdo').modal('show');
    });
</script>
@endsection

