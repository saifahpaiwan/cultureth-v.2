@extends('layouts.app-front')
@section('meta')  
    <meta name="title" content=" @if(isset($data['result']->annual_meta_title)) {{ $data['result']->annual_meta_title }} @endif">
    <meta name="description" content="@if(isset($data['result']->annual_meta_description)) {{ $data['result']->annual_meta_description }} @endif">
    <meta name="keywords" content="@if(isset($data['result']->annual_meta_keyword)) {{ $data['result']->annual_meta_keyword }} @endif">
    
    <!-- Open Graph / Faceannual -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('reportannual.view', [$data['get_id']]) }}">
    <meta property="og:title" content=" @if(isset($data['result']->annual_meta_title)) {{ $data['result']->annual_meta_title }} @endif">
    <meta property="og:description" content="@if(isset($data['result']->annual_meta_description)) {{ $data['result']->annual_meta_description }} @endif">
    <meta property="og:keywords" content="@if(isset($data['result']->annual_meta_keyword)) {{ $data['result']->annual_meta_keyword }} @endif">
    <meta property="og:image" content="@if(isset($data['result']->annual_image_thumb_desktop)) {{ asset('images/annual').'/'.$data['result']->annual_image_thumb_desktop }} @endif ">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('reportannual.view', [$data['get_id']]) }}">
    <meta property="twitter:title" content=" @if(isset($data['result']->annual_meta_title)) {{ $data['result']->annual_meta_title }} @endif">
    <meta property="twitter:description" content="@if(isset($data['result']->annual_meta_description)) {{ $data['result']->annual_meta_description }} @endif">
    <meta property="twitter:keywords" content="@if(isset($data['result']->annual_meta_keywords)) {{ $data['result']->annual_meta_keywords }} @endif">
    <meta property="twitter:image" content="@if(isset($data['result']->annual_image_thumb_desktop)) {{ asset('images/annual').'/'.$data['result']->annual_image_thumb_desktop }} @endif">
@endsection
@section('style')   
<style>   
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
</style> 
@endsection
@section('content') 
    <div class="container bg-white">  
        <section class="hero">
            <div class="hero-texts">
                <h1 class=""> ????????????????????????????????????????????????????????????/??????????????????????????????????????? </h1> 
            </div>
        </section>
        <section class=""> 
            <div class="row p-3 px-md-5">   
                <div class="col-md-12"> 
                    <h4 class=""> {{ $data['result']->annual_title }} </h4>
                    <div class="mb-2"> {{ $data['result']->annual_intro }} </div>
                    <div class="font-13 mb-2"> <i class="fe-calendar"></i> {{ date("d/m/Y", strtotime($data['result']->created_at)) }} </div>
                    <div class="d-flex"> 
                        <div class="sharethis-inline-share-buttons" style="height: 0;"></div> 
                        <a href="{{ route('reportannual') }}" class="btn ml-5"> ???????????????????????? </a>  
                    </div>
                </div>
            </div>
            <hr>
            <div class="row p-3 px-md-5">  
                <div class="col-md-12 pb-4">  
                    @if(isset($data['result']->file_pdf))
                        @if(!empty($data['result']->file_pdf)) 
                            <div class="text-center mb-3 d-none d-sm-block">  
                                <object data="{{ asset('images/annual/pdf').'/'.$data['result']->file_pdf }}" type="application/pdf" width="100%" height="100%"> </object>
                            </div> 
                            <div class="text-center mb-3 d-block d-sm-none">  
                                <div><b>??????????????????????????????????????????????????????????????????????????? PDF ?????????????????????????????????????????????????????? PDF ?????????????????????</b> </div>
                                <a class="btn mt-1" href="{{ asset('images/annual/pdf').'/'.$data['result']->file_pdf }}">Download PDF</a>
                            </div>  
                        @endif
                    @endif
                    <?php 
                        if(isset($data['result']->annual_file_text)){
                            echo file_get_contents(storage_path().'/app/'.$data['result']->annual_file_text); 
                        }
                    ?> 
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

