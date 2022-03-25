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
                <h4 class="page-title"> <i class="dripicons-broadcast"></i> ข่าวประชาสัมพันธ์  </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">   
                  <div class="col-md-12"> 
                    <h5 class="m-0"> แก้ไขข่าวประชาสัมพันธ์ 
                    <a href="{{ route('news.list') }}" class="float-right"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
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
                <form method="POST" action="{{ route('save.news') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="U">
                  <input type="hidden" id="id" name="id" value="{{ $data['news_find']->id }}">

                  <div class="row"> 
                    <div class="col-md-5"> 
                      <div class="row"> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="news_title"> ชื่อข่าวประชาสัมพันธ์ <span class="text-danger">*</span></label>
                          <input id="news_title" type="text" class="form-control form-control-lg @error('news_title') invalid @enderror" name="news_title"  
                          value="{{ $data['news_find']->news_title }}"
                          required autocomplete="news_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('news_title')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="news_intro"> รายละเอียดย่อ <span class="text-danger">*</span></label>
                          <textarea class="form-control form-control-lg @error('news_intro') invalid @enderror" rows="2" id="news_intro" name="news_intro" autocomplete="news_intro" autofocus placeholder="โปรดระบุข้อมูล..." required>{{ $data['news_find']->news_intro }}</textarea>
                          @error('news_intro')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                        
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="news_meta_title"> News Meta Title </label>
                          <input id="news_meta_title" type="text" class="form-control form-control-lg @error('news_meta_title') invalid @enderror" name="news_meta_title"  
                          value="{{ $data['news_find']->news_meta_title }}"
                          autocomplete="news_meta_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('news_meta_title')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="news_meta_description"> News Meta Description </label>
                          <input id="news_meta_description" type="text" class="form-control form-control-lg @error('news_meta_description') invalid @enderror" name="news_meta_description"  
                          value="{{ $data['news_find']->news_meta_description }}"
                          autocomplete="news_meta_description" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('news_meta_description')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="news_meta_keyword"> News Meta Keyword </label>
                          <input id="news_meta_keyword" type="text" class="form-control form-control-lg @error('news_meta_keyword') invalid @enderror" name="news_meta_keyword"  
                          value="{{ $data['news_find']->news_meta_keyword }}"
                          autocomplete="news_meta_keyword" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('news_meta_keyword')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
    
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>  
                          <div class="cc-selector"> 
                            <input id="status1" type="radio" name="status" value="0" {{  $data['news_find']->deleted_at == true ?  $data['news_find']->deleted_at == 0 ? "checked" : ""  : "checked"  }}/>
                            <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>  

                            <input id="status2" type="radio" name="status" value="1" {{  $data['news_find']->deleted_at == 1 ? "checked" : "" }}/>
                            <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label> 
                          </div> 
                        </div>   
                        <div class="col-md-12 form-group">  
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
                              <input type="hidden" id="file_upload_pdf_hdf" name="file_upload_pdf_hdf" value="{{ $data['news_find']->file_pdf }}">
                            </div>
                            @if(!empty($data['news_find']->file_pdf))
                              <a href="javascript: void(0);" data-file="{{ $data['news_find']->file_pdf }}" class="h2 m-0 text-danger" id="close-pdf"><i class="fe-trash-2"></i></a> 
                            @endif
                          </div>
                          <span class="mt-1 ml-1" style="font-size: 10px;"> {{ $data['news_find']->file_pdf }} </span>
                          @error('file_upload_pdf')  
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror 
                        </div>
                        <div class="col-md-6"> 
                          <div class="mb-1">
                            <label for="file_upload"> รูปแสดงผลการแชร์ Thumb <span class="text-danger">*</span></label>
                            <div class="img-file-upload-1"> 
                              <img src="{{ asset('images/news').'/'.$data['news_find']->news_image_thumb_desktop }}" class="event-icon" style="width: 150px; border: 1px solid #ddd;"> 
                            </div>
                            <div class="mt-1 mb-1" style="font-size: 10px;"> Size image 500*400  2MB. </div>
                            <input id="file_upload" type="file" class="@error('file_upload') invalid @enderror" name="file_upload"  
                            value="{{ old('file_upload') }}"
                             autocomplete="file_upload" autofocus> 
                            <input type="hidden" id="file_upload_hdf" name="file_upload_hdf" value="{{ $data['news_find']->news_image_thumb_desktop }}">
                            @error('file_upload') 
                              <span class="invalid-feedback" role="alert">
                                  <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-1">
                            <label for="file_upload_dektop"> รูปแสดงผลบน Web <span class="text-danger">*</span></label>
                            <div class="img-file-upload-2"> 
                              <img src="{{ asset('images/news').'/'.$data['news_find']->news_image_desktop }}" class="event-icon" style="width: 150px; border: 1px solid #ddd;"> 
                            </div>
                            <div class="mt-1 mb-1" style="font-size: 10px;"> Size image 500*400  2MB. </div>
                            <input id="file_upload_dektop" type="file" class="@error('file_upload_dektop') invalid @enderror" name="file_upload_dektop"  
                            value="{{ old('file_upload_dektop') }}"
                             autocomplete="file_upload_dektop" autofocus> 
                            <input type="hidden" id="file_upload_dektop_hdf" name="file_upload_dektop_hdf" value="{{ $data['news_find']->news_image_desktop }}">
                            @error('file_upload_dektop') 
                              <span class="invalid-feedback" role="alert">
                                  <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>   
                      </div>
                    </div>
                    <div class="col-md-7">  
                      <label for="news_file_text">รายละเอียดข่าวประชาสัมพันธ์ <span class="text-danger">*</span></label>
                      <div class="news_file_text"><?php echo file_get_contents(storage_path().'/app/'.$data['news_find']->news_file_text); ?> </div>
                      <input type="hidden" id="news_file_text" name="news_file_text" value="">
                      <input type="hidden" id="news_file_text_hdfs" name="news_file_text_hdfs" value="{{ $data['news_find']->news_file_text }}">  
                      @error('news_file_text') 
                        <span class="invalid-feedback" role="alert">
                          <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

                  <hr>
                  <div class="row"> 
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('news.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>  
                      <button type="button" class="btn btn-lg btn-danger waves-effect waves-light" id="close" data-id="{{ $data['news_find']->id }}"> 
                        <i class="mdi mdi-delete"></i> ยกเลิกข้อมูล 
                      </button> 
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
          $.post("{{ route('close.newspdf') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
            file: file,
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
    var sum_val =$(".news_file_text").summernote('code'); 
    $('input[name=news_file_text]').val(sum_val);
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 
  $('#news_status').select2(); 
  $('.news_file_text').summernote({
    height: 820,                
    minHeight: null, 
    maxHeight: null,  
    focus: false 
  });  

  $(document).on('change', '#file_upload', function(event) {
      var img="{{ asset('images/no-img.png') }}";
      html='<img src="'+img+'" class="event-icon" style="width: 150px; border: 1px solid #ddd;">';    
      $('.img-file-upload-1').html(html);
      var Images = $('#file_upload'); 
      if ( Images[0].files[0] ){ 
        url=window.URL.createObjectURL(Images[0].files[0]);
        html='<img src="'+url+'" class="event-icon" style="width: 150px; border: 1px solid #ddd;">'; 
      }
      $('.img-file-upload-1').html(html);
  });

  $(document).on('change', '#file_upload_dektop', function(event) { 
      var img="{{ asset('images/no-img.png') }}";
      html='<img src="'+img+'" class="event-icon" style="width: 150px; border: 1px solid #ddd;">';      
      var Images = $('#file_upload_dektop'); 
      if ( Images[0].files[0] ){ 
        url=window.URL.createObjectURL(Images[0].files[0]);
        html='<img src="'+url+'" class="event-icon" style="width: 150px; border: 1px solid #ddd;">'; 
      }
      $('.img-file-upload-2').html(html);
  }); 
  setTimeout(function(){ $('.alert-success').fadeOut(); }, 3000);
  
  $(document).on('click', '#close', function(event) { 
    var id=$(this)[0].dataset.id; 
    var vthis=$(this);
    vthis[0].innerHTML='<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...';
    Swal.fire({
        title: 'ยืนยันการยกเลิกข้อมูล หรือไม่?',
        text: "ระบบจะทำการยกเลิกข้อมูล และจะไม่สามารถนำกลับได้ !",
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:"Yes",
        cancelButtonText:"No",
        confirmButtonClass:"btn btn-primary btn-lg",
        cancelButtonClass:"btn btn-secondary btn-lg ml-1",
        buttonsStyling:!1
    }).then((result) => { 
        if (result.value) {  
          $.post("{{ route('close.news') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              location.href = "{{ route('news.list') }}";
            }
          })
          .fail(function(xhr, status, error) { 
            alert('An error occurred, please try again.'); 
            // location.reload();
          });  
        } else {
          vthis[0].innerHTML='<i class="mdi mdi-delete"></i> ยกเลิกข้อมูล';  
        }
    }); 
  }); 
</script>
@endsection

