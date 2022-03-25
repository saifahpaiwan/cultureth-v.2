@extends('layouts.app')
@section('style')      
  <link href="{{ asset('admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />   
  <link href="{{ asset('admin/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />  
  <link href="{{ asset('admin/libs/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
  <style> 
    .select2-container--default .select2-selection--single { height: 42px;    border: 1px solid #dee2e6; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 42px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px;}  
  </style>
@endsection
@section('content')
    <div class="content"> 
      <div class="container-fluid"> 
        <div class="row">
          <div class="col-12">
              <div class="page-title-box"> 
                <h4 class="page-title"> <i class="fe-layout"></i>  แก้ไขหน้าเว็บไซต์   </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">   
                  <div class="col-md-12"> 
                    <h5 class="m-0"> {{ "แก้ไข".$data['title'] }}
                    <a href="{{ route('home') }}" class="float-right"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                    </h5>
                  </div> 
                </div>
              </div>
              <div class="card-body">  
                @if(session("success"))
                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                    <i class="icon-check"></i> {{session("success")}} 
                  </div> 
                @endif  
                <form method="POST" action="{{ route('save.pages') }}" id="form" enctype="multipart/form-data">
                  @csrf   
                  <input type="hidden" id="db" name="db" value="{{ $data['db'] }}">
                  <input type="hidden" id="get_id" name="get_id" value="{{ $data['get_id'] }}">
                  <input type="hidden" id="statusData" name="statusData" value="@if(isset($data['Query_find']->id)) {{ __('U') }}  @else {{ __('C') }}  @endif">
                  <div class="row"> 
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="title"> ชื่อหัวข้อ <span class="text-danger">*</span></label>
                      <input id="title" type="text" class="form-control form-control-lg @error('title') invalid @enderror" name="title"  
                      value="@if(isset($data['Query_find']->id)) {{ $data['Query_find']->title }}  @endif"
                      required autocomplete="title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('title')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="sub_title"> ชื่อหัวข้อย่อย </label>
                      <input id="sub_title" type="text" class="form-control form-control-lg @error('sub_title') invalid @enderror" name="sub_title"  
                      value="@if(isset($data['Query_find']->id)) {{ $data['Query_find']->sub_title }} @endif"
                      autocomplete="sub_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('sub_title')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>   
                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="meta_title"> News Meta Title </label>
                      <input id="meta_title" type="text" class="form-control form-control-lg @error('meta_title') invalid @enderror" name="meta_title"  
                      value="@if(isset($data['Query_find']->id)) {{ $data['Query_find']->meta_title }} @endif"
                      autocomplete="meta_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('meta_title')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="meta_description"> News Meta Description </label>
                      <input id="meta_description" type="text" class="form-control form-control-lg @error('meta_description') invalid @enderror" name="meta_description"  
                      value="@if(isset($data['Query_find']->id)) {{ $data['Query_find']->meta_description }} @endif"
                      autocomplete="meta_description" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('meta_description')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="meta_keyword"> News Meta Keyword </label>
                      <input id="meta_keyword" type="text" class="form-control form-control-lg @error('meta_keyword') invalid @enderror" name="meta_keyword"  
                      value="@if(isset($data['Query_find']->id)) {{ $data['Query_find']->meta_keyword }} @endif"
                      autocomplete="meta_keyword" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('meta_keyword')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>  
                    <div class="col-md-3 form-group"> 
                      <label for="file_upload"> รูปแสดงผลการแชร์ Thumb <span class="text-danger">*</span></label>
                      <div class="img-file-upload-1"> 
                        <img src="@if(isset($data['Query_find']->id)) {{ asset('images/page_edit').'/'.$data['Query_find']->image_thumb_desktop }} @else {{ asset('images/no-img.png') }}  @endif" class="event-icon" style="width: 80px; border: 1px solid #ddd;"> 
                      </div>
                      <div class="mt-1 mb-1" style="font-size: 10px;"> Size image 500*400  2MB. </div>
                      <input id="file_upload" type="file" class="@error('file_upload') invalid @enderror" name="file_upload"  
                      value="{{ old('file_upload') }}"
                      autocomplete="file_upload" autofocus> 
                      <input type="hidden" id="file_upload_hdf" name="file_upload_hdf" value="@if(isset($data['Query_find']->id)) {{ $data['Query_find']->image_thumb_desktop }} @endif">
                      @error('file_upload') 
                        <span class="invalid-feedback" role="alert">
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="col-md-4 form-group"> 
                      <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>  
                      <div class="cc-selector"> 
                        <?php 
                          $status=0;
                          if(isset($data['Query_find']->deleted_at)){
                            $status=$data['Query_find']->deleted_at;
                          }  
                        ?>
                        <input id="status1" type="radio" name="status" value="0" {{ $status == true ? $status == 0 ? "checked" : ""  : "checked"  }}/>
                        <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>  

                        <input id="status2" type="radio" name="status" value="1" {{ $status == 1 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label> 
                      </div> 
                    </div>

                    <div class="col-md-5 form-group">  
                      <div class="d-flex mt-3">
                        <div>
                          <div class="img-file-upload-pdf"> 
                            <img src="{{ asset('images/pdf.png') }}" class="event-icon" style="width: 45px;"> 
                          </div> 
                        </div>
                        <div class="ml-2" style="width: 215px;">
                          <div> อัพโหลดไฟล์ PDF ถ้ามี Size 30MB.</div>
                          <input id="file_upload_pdf" type="file" class="@error('file_upload_pdf') invalid @enderror" name="file_upload_pdf"  
                          value="{{ old('file_upload_pdf') }}"
                          autocomplete="file_upload_pdf" autofocus> 
                          <input type="hidden" id="file_upload_pdf_hdf" name="file_upload_pdf_hdf" value="@if(!empty($data['Query_find']->file_pdf)) {{ $data['Query_find']->file_pdf }} @endif">
                        </div>
                        @if(!empty($data['Query_find']->file_pdf))
                          <a href="javascript: void(0);" data-file="@if(!empty($data['Query_find']->file_pdf)) {{ $data['Query_find']->file_pdf }} @endif" class="h2 m-0 text-danger" id="close-pdf"><i class="fe-trash-2"></i></a> 
                        @endif
                      </div>
                      <span class="mt-1 ml-1" style="font-size: 10px;"> @if(!empty($data['Query_find']->file_pdf)) {{ $data['Query_find']->file_pdf }} @endif </span>
                      @error('file_upload_pdf')  
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror 
                    </div> 

                    <div class="col-md-12">  
                     <label for="file_text">รายละเอียดประวัติความเป็นมา <span class="text-danger">*</span></label>
                      <div class="file_text"><?php if(isset($data['Query_find']->id)){ echo file_get_contents(storage_path().'/app/'.$data['Query_find']->file_text); } ?></div>
                      <input type="hidden" id="file_text" name="file_text" value="">
                      <input type="hidden" id="file_text_hdfs" name="file_text_hdfs" value="@if(isset($data['Query_find']->id)) {{ $data['Query_find']->file_text }} @endif">  
                      @error('file_text') 
                        <span class="invalid-feedback" role="alert">
                          <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div> 
                  <hr>
                  <div class="row"> 
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('home') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>  
                      <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"> 
                        <span class="text-submit"> <i class="fe-save"></i> บันทึกข้อมูล </span>
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
  
@endsection
@section('script')    
<script src="{{ asset('admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>    
<script src="{{ asset('admin/libs/select2/select2.min.js') }}"></script> 
<script src="{{ asset('admin/libs/summernote/summernote-bs4.min.js') }}"></script>
<script>  
  $(document).on('click', '#close-pdf', function(event) { 
    var file=$(this)[0].dataset.file; 
    var id=$('#id').val();
    var db=$('#db').val();
    
    Swal.fire({
        title: 'ยืนยันการลบไฟล์ หรือไม่?',
        text: "ระบบจะทำการลบไฟล์ และจะไม่สามารถนำกลับได้ !",
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:"Yes",
        cancelButtonText:"No",
        confirmButtonClass:"btn btn-primary btn-lg",
        cancelButtonClass:"btn btn-secondary btn-lg ml-1",
        buttonsStyling:!1
    }).then((result) => { 
        if (result.value) {  
          $.post("{{ route('close.pages.pdf') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
            file: file,
            db: db,
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              location.reload();
            }
          })
          .fail(function(xhr, status, error) { 
            alert('An error occurred, please try again.'); 
            location.reload();
          });  
        }  
    }); 
  });


  $( "form" ).submit(function( event ) {  
    var sum_val =$(".file_text").summernote('code'); 
    $('input[name=file_text]').val(sum_val);
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 
  $('#status').select2(); 
  $('.file_text').summernote({
    height: 500,                
    minHeight: null, 
    maxHeight: null,  
    focus: false 
  });   
  setTimeout(function(){ $('.alert-success').fadeOut(); }, 3000);
  $(document).on('change', '#file_upload', function(event) {
    var img="{{ asset('images/no-img.png') }}";
    html='<img src="'+img+'" class="event-icon" style="width: 80px; border: 1px solid #ddd;">';    
    $('.img-file-upload-1').html(html);
    var Images = $('#file_upload'); 
    if ( Images[0].files[0] ){ 
      url=window.URL.createObjectURL(Images[0].files[0]);
      html='<img src="'+url+'" class="event-icon" style="width: 80px; border: 1px solid #ddd;">'; 
    }
    $('.img-file-upload-1').html(html);
  });
</script>
@endsection

