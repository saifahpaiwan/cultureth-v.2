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
                <h4 class="page-title"> <i class="dripicons-calendar"></i> กิจกรรม  </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">   
                  <div class="col-md-12"> 
                    <h5 class="m-0"> แก้ไขกิจกรรม 
                    <a href="{{ route('activity.list') }}" class="float-right"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
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
                <form method="POST" action="{{ route('save.activity') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="U">
                  <input type="hidden" id="id" name="id" value="{{ $data['activity_find']->id }}">

                  <div class="row"> 
                    <div class="col-md-5"> 
                      <div class="row"> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="activity_title"> ชื่อกิจกรรม <span class="text-danger">*</span></label>
                          <input id="activity_title" type="text" class="form-control form-control-lg @error('activity_title') invalid @enderror" name="activity_title"  
                          value="{{ $data['activity_find']->activity_title }}"
                          required autocomplete="activity_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('activity_title')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="activity_intro"> รายละเอียดย่อ <span class="text-danger">*</span></label>
                          <textarea class="form-control form-control-lg @error('activity_intro') invalid @enderror" rows="2" id="activity_intro" name="activity_intro" autocomplete="activity_intro" autofocus placeholder="โปรดระบุข้อมูล..." required>{{ $data['activity_find']->activity_intro }}</textarea>
                          @error('activity_intro')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                         
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="activity_meta_title"> Activity Meta Title </label>
                          <input id="activity_meta_title" type="text" class="form-control form-control-lg @error('activity_meta_title') invalid @enderror" name="activity_meta_title"  
                          value="{{ $data['activity_find']->activity_meta_title }}"
                          autocomplete="activity_meta_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('activity_meta_title')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="activity_meta_description"> Activity Meta Description </label>
                          <input id="activity_meta_description" type="text" class="form-control form-control-lg @error('activity_meta_description') invalid @enderror" name="activity_meta_description"  
                          value="{{ $data['activity_find']->activity_meta_description }}"
                          autocomplete="activity_meta_description" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('activity_meta_description')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="activity_meta_keyword"> Activity Meta Keyword </label>
                          <input id="activity_meta_keyword" type="text" class="form-control form-control-lg @error('activity_meta_keyword') invalid @enderror" name="activity_meta_keyword"  
                          value="{{ $data['activity_find']->activity_meta_keyword }}"
                          autocomplete="activity_meta_keyword" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('activity_meta_keyword')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
    
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>  
                          <div class="cc-selector"> 
                            <input id="status1" type="radio" name="status" value="0" {{  $data['activity_find']->deleted_at == true ?  $data['activity_find']->deleted_at == 0 ? "checked" : ""  : "checked"  }}/>
                            <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>  

                            <input id="status2" type="radio" name="status" value="1" {{  $data['activity_find']->deleted_at == 1 ? "checked" : "" }}/>
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
                              <input type="hidden" id="file_upload_pdf_hdf" name="file_upload_pdf_hdf" value="{{ $data['activity_find']->file_pdf }}">
                            </div>
                            @if(!empty($data['activity_find']->file_pdf))
                              <a href="javascript: void(0);" data-file="{{ $data['activity_find']->file_pdf }}" class="h2 m-0 text-danger" id="close-pdf"><i class="fe-trash-2"></i></a> 
                            @endif
                          </div>
                          <span class="mt-1 ml-1" style="font-size: 10px;"> {{ $data['activity_find']->file_pdf }} </span>
                          @error('file_upload_pdf')  
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror 
                        </div> 
                        <div class="col-md-6"> 
                          <div class="mb-1">
                            <label for="file_upload"> รูปแสดงผลการแชร์ Thumb <span class="text-danger">*</span></label>
                            <div class="img-file-upload-1"> 
                              <img src="{{ asset('images/activity').'/'.$data['activity_find']->activity_image_thumb_desktop }}" class="event-icon" style="width: 150px; border: 1px solid #ddd;"> 
                            </div>
                            <div class="mt-1 mb-1" style="font-size: 10px;"> Size image 500*400  2MB. </div>
                            <input id="file_upload" type="file" class="@error('file_upload') invalid @enderror" name="file_upload"  
                            value="{{ old('file_upload') }}"
                             autocomplete="file_upload" autofocus> 
                            <input type="hidden" id="file_upload_hdf" name="file_upload_hdf" value="{{ $data['activity_find']->activity_image_thumb_desktop }}">
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
                              <img src="{{ asset('images/activity').'/'.$data['activity_find']->activity_image_desktop }}" class="event-icon" style="width: 150px; border: 1px solid #ddd;"> 
                            </div>
                            <div class="mt-1 mb-1" style="font-size: 10px;"> Size image 500*400  2MB. </div>
                            <input id="file_upload_dektop" type="file" class="@error('file_upload_dektop') invalid @enderror" name="file_upload_dektop"  
                            value="{{ old('file_upload_dektop') }}"
                             autocomplete="file_upload_dektop" autofocus> 
                            <input type="hidden" id="file_upload_dektop_hdf" name="file_upload_dektop_hdf" value="{{ $data['activity_find']->activity_image_desktop }}">
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
                      <div class="mb-2"> 
                        <label for="file_upload_galleries"> รูป Galleries (สามารถเพิ่มได้มากกว่าหนึ่งรูป) </label>
                        <div class="img-file-upload-galleries"> 
                          @if(isset($data['activity_gallery']))
                            @if(count($data['activity_gallery'])>0)
                              @foreach($data['activity_gallery'] as $row)
                                <img src="{{ asset('images/activity/galleries').'/'.$row->image }}" class="event-icon" style="width: 80px; border: 1px solid #ddd;">   
                              @endforeach
                              <a href="javascript: void(0);" class="h2 m-0 text-danger" id="close-galleries"><i class="fe-trash-2"></i></a>
                            @else
                              <img src="{{ asset('images/no-img.png') }}" class="event-icon" style="width: 80px; border: 1px solid #ddd;">
                            @endif 
                          @endif 
                        </div>
                        <div class="mt-1 mb-1" style="font-size: 10px;"> Size image 500*400  2MB. </div>
                        <input id="file_upload_galleries" type="file" class="@error('file_upload_galleries') invalid @enderror" name="file_upload_galleries[]" multiple  
                        value="{{ old('file_upload_galleries') }}"
                        autocomplete="file_upload_galleries" autofocus> 
                        <input type="hidden" id="file_upload_galleries_hdf" name="file_upload_galleries_hdf" value="">
                        @error('file_upload_galleries') 
                          <span class="invalid-feedback" role="alert">
                              <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>  
                      <div class="mb-2"> 
                        <label for="activity_file_text">รายละเอียดกิจกรรม <span class="text-danger">*</span></label>
                        <div class="activity_file_text"><?php echo file_get_contents(storage_path().'/app/'.$data['activity_find']->activity_file_text); ?> </div>
                        <input type="hidden" id="activity_file_text" name="activity_file_text" value="">
                        <input type="hidden" id="activity_file_text_hdfs" name="activity_file_text_hdfs" value="{{ $data['activity_find']->activity_file_text }}">  
                        @error('activity_file_text') 
                          <span class="invalid-feedback" role="alert">
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                  </div> 
                  <hr>
                  <div class="row"> 
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('activity.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>  
                      <button type="button" class="btn btn-lg btn-danger waves-effect waves-light" id="close" data-id="{{ $data['activity_find']->id }}"> 
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
  $(document).on('change', '#file_upload_galleries', function(event) {
    var Images = $('#file_upload_galleries'); 
    var length = Images[0].files.length;
    var img = "";
    for(var i=0; i<=(length-1); i++){  
        img+='<img src="'+window.URL.createObjectURL(Images[0].files[i])+'" class="event-icon" style="width: 80px; border: 1px solid #ddd;">';
    } 
    $('.img-file-upload-galleries').html(img);
  }); 
  
  $(document).on('click', '#close-galleries', function(event) {  
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
          $.post("{{ route('close.activity.galleries') }}", {
            _token: "{{ csrf_token() }}",  
            id: id,  
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
          $.post("{{ route('close.activity.pdf') }}", {
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
    var sum_val =$(".activity_file_text").summernote('code'); 
    $('input[name=activity_file_text]').val(sum_val);
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 
  $('#activity_status').select2(); 
  $('.activity_file_text').summernote({
    height: 580,                
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
          $.post("{{ route('close.activity') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              location.href = "{{ route('activity.list') }}";
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

