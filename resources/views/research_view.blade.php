@extends('layouts.app-front')
@section('meta')  
    <meta name="title" content=" @if(isset($data['result']->research_meta_title)) {{ $data['result']->research_meta_title }} @endif">
    <meta name="description" content="@if(isset($data['result']->research_meta_description)) {{ $data['result']->research_meta_description }} @endif">
    <meta name="keywords" content="@if(isset($data['result']->research_meta_keyword)) {{ $data['result']->research_meta_keyword }} @endif">
    
    <!-- Open Graph / Faceresearch -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('research.view', [$data['get_id']]) }}">
    <meta property="og:title" content=" @if(isset($data['result']->research_meta_title)) {{ $data['result']->research_meta_title }} @endif">
    <meta property="og:description" content="@if(isset($data['result']->research_meta_description)) {{ $data['result']->research_meta_description }} @endif">
    <meta property="og:keywords" content="@if(isset($data['result']->research_meta_keyword)) {{ $data['result']->research_meta_keyword }} @endif">
    <meta property="og:image" content="@if(isset($data['result']->research_image_thumb_desktop)) {{ asset('images/research').'/'.$data['result']->research_image_thumb_desktop }} @endif ">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('research.view', [$data['get_id']]) }}">
    <meta property="twitter:title" content=" @if(isset($data['result']->research_meta_title)) {{ $data['result']->research_meta_title }} @endif">
    <meta property="twitter:description" content="@if(isset($data['result']->research_meta_description)) {{ $data['result']->research_meta_description }} @endif">
    <meta property="twitter:keywords" content="@if(isset($data['result']->research_meta_keywords)) {{ $data['result']->research_meta_keywords }} @endif">
    <meta property="twitter:image" content="@if(isset($data['result']->research_image_thumb_desktop)) {{ asset('images/research').'/'.$data['result']->research_image_thumb_desktop }} @endif">
@endsection
@section('style')   
<style>   
    .hero {
        background: -webkit-gradient(linear, left top, left bottom, from(rgba(69, 57, 71, 0.7)), to(rgba(69, 57, 71, 0.9))), url("{{ asset('images/hero3.jpg') }}") center/cover repeat;
        background: linear-gradient(rgba(69, 57, 71, 0.7), rgba(69, 57, 71, 0.9)), url("{{ asset('images/hero3.jpg') }}") center/cover repeat;
    } 
</style> 
@endsection
@section('content') 
    <div class="container bg-white">  
        <section class="hero">
            <div class="hero-texts">
                <h1 class=""> หนังสือและวารสารสำนักฯ </h1> 
            </div>
        </section>
        <section class=""> 
            <div class="row p-3 px-md-5">  
                <div class="col-md-4"> 
                    <img  src="{{ asset('images/research').'/'.$data['result']->research_image_desktop }}" class="img-fluid">
                </div>
                <div class="col-md-8"> 
                    <h4 class=""> {{ $data['result']->research_title }} </h4>
                    <div class="font-13 mb-2"> <i class="fe-calendar"></i> {{ date("d/m/Y", strtotime($data['result']->created_at)) }} </div>
                    <div class="sharethis-inline-share-buttons mb-3"></div>
                    <div class="mb-2"> <b class="">ชื่อผู้แต่ง : </b>	 {{ $data['result']->research_name }} </div>
                    <div class="mb-2"> <b class="">ปีที่พิมพ์ : </b>     {{ $data['result']->research_year }} </div>
                    <div class="mb-2"> <b class="">จัดพิมพ์โดย : </b>  {{ $data['result']->research_publishing_agency }}</div>
                    <p class="font-13"> คำสำคัญ : {{ $data['result']->research_keyword }}</p> 
                    <p class="font-13"> บทคัดย่อ : {{ $data['result']->research_detial }}</p> 

                    <a href="{{ route('research') }}" class="btn mt-1"> ย้อนกลับ </a> 
                    @if(!empty($data['result']->research_file_pdf))
                    <a target="_blank" href="{{ asset('images/research/pdf').'/'.$data['result']->research_file_pdf }}" class="btn mt-1"> เริ่มอ่าน </a> 
                    @endif
                </div>
            </div>
        </section> 
    </div>
@endsection
@section('script')   
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=62335409b947cf001aac6740&product=inline-share-buttons" async="async"></script>
<script>  
</script>
@endsection

