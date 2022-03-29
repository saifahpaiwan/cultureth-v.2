@extends('layouts.app-front')
@section('meta')  
    <meta name="title" content=" @if(isset($data['retule']->meta_title)) {{ $data['retule']->meta_title }} @endif">
    <meta name="description" content="@if(isset($data['retule']->meta_description)) {{ $data['retule']->meta_description }} @endif">
    <meta name="keywords" content="@if(isset($data['retule']->meta_keyword)) {{ $data['retule']->meta_keyword }} @endif">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('about.history') }}">
    <meta property="og:title" content=" @if(isset($data['retule']->meta_title)) {{ $data['retule']->meta_title }} @endif">
    <meta property="og:description" content="@if(isset($data['retule']->meta_description)) {{ $data['retule']->meta_description }} @endif">
    <meta property="og:keywords" content="@if(isset($data['retule']->meta_keyword)) {{ $data['retule']->meta_keyword }} @endif">
    <meta property="og:image" content="@if(isset($data['retule']->image_thumb_desktop)) {{ asset('images/page_edit').'/'.$data['retule']->image_thumb_desktop }} @endif ">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('about.history') }}">
    <meta property="twitter:title" content=" @if(isset($data['retule']->meta_title)) {{ $data['retule']->meta_title }} @endif">
    <meta property="twitter:description" content="@if(isset($data['retule']->meta_description)) {{ $data['retule']->meta_description }} @endif">
    <meta property="twitter:keywords" content="@if(isset($data['retule']->meta_keywords)) {{ $data['retule']->meta_keywords }} @endif">
    <meta property="twitter:image" content="@if(isset($data['retule']->image_thumb_desktop)) {{ asset('images/page_edit').'/'.$data['retule']->image_thumb_desktop }} @endif">
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
.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
</style> 
@endsection
@section('content') 
    <div class="container bg-white">  
        <section class="hero">
            <div class="hero-texts"> 
                <h1 class="display-4">@if(isset($data['retule']->title)) {{ $data['retule']->title }} @endif</h1>
                <h2>@if(isset($data['retule']->sub_title)) {{ $data['retule']->sub_title }} @endif</h2>
            </div>
        </section>
        
        <div class="row pt-2 pb-2 px-md-5">  
            <div class="col-md-12"> 
                <div class="content-file pt-4 pb-4">
                    @if(isset($data['retule']->file_pdf))
                        @if(!empty($data['retule']->file_pdf))
                            <div class="text-center mb-3">  
                                <object data="{{ asset('images/page_edit/pdf').'/'.$data['retule']->file_pdf }}" type="application/pdf" width="100%" height="100%">
                                    <div><b>เบราว์เซอร์นี้ไม่สนับสนุน PDF กรุณาดาวน์โหลดไฟล์ PDF เพื่อดู</b> </div>
                                    <a class="btn mt-1" href="{{ asset('images/page_edit/pdf').'/'.$data['retule']->file_pdf }}">Download PDF</a>  
                                </object>
                            </div> 
                        @endif
                    @endif
                    <?php 
                        if(isset($data['retule']->file_text)){
                            echo file_get_contents(storage_path().'/app/'.$data['retule']->file_text); 
                        }
                    ?> 
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')    
<script> 
 
</script>
@endsection

