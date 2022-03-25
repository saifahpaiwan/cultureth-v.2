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
                <h4 class="page-title"> <i class="fe-box"></i> แหล่งเรียนรู้ </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">   
                  <div class="col-md-12"> 
                    <h5 class="m-0"> แก้ไขแหล่งเรียนรู้ 
                    <a href="{{ route('learning.list') }}" class="float-right"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
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
                
                <form method="POST" action="{{ route('save.learning') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="U">
                  <input type="hidden" id="id" name="id" value="{{ $data['learning_find']->id }}">

                  <div class="row"> 
                    <div class="col-md-5"> 
                      <div class="row"> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="learning_title"> ชื่อแหล่งเรียนรู้ <span class="text-danger">*</span></label>
                          <input id="learning_title" type="text" class="form-control form-control-lg @error('learning_title') invalid @enderror" name="learning_title"  
                          value="{{ $data['learning_find']->learning_title }}"
                          required autocomplete="learning_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('learning_title')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>
                        
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="learning_category"> ประเภทแหล่งเรียนรู้ <span class="text-danger">*</span></label> 
                          <a href="{{ route('learningcategory.add') }}" class="float-right"> <i class="fe-plus-circle"></i> เพิ่มข้อมูล </a>
                          <select id="learning_category" name="learning_category" class="form-control  @error('learning_category') invalid @enderror" data-toggle="select2" required>
                            <option value=""> เลือกประเภทแหล่งเรียนรู้ </option>
                            @if(isset($data['Query_learning_category']))
                              @foreach($data['Query_learning_category'] as $row)
                                <option title="{{ $row->detail }}" @if($data['learning_find']->learning_category==$row->id) {{ __('selected') }} @endif value="{{ $row->id }}" title="{{ $row->detail }}"> {{ $row->name }} </option>
                              @endforeach
                            @endif  
                          </select>  
                          @error('learning_category')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>
                        
                        <div class="col-md-9 form-group"> 
                          <label class="ml-1" for="learning_location"> สถานที่ตั้ง <span class="text-danger">*</span></label>
                          <input id="learning_location" type="text" class="form-control form-control-lg @error('learning_location') invalid @enderror" name="learning_location"  
                          value="{{ $data['learning_find']->learning_location }}"
                          required autocomplete="learning_location" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('learning_location')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>
                        
                        <div class="col-md-3 form-group"> 
                          <label class="ml-1" for="learning_year"> ปีที่ <span class="text-danger">*</span></label>
                          <input id="learning_year" type="number" class="form-control form-control-lg @error('learning_year') invalid @enderror" name="learning_year"  
                          value="{{ $data['learning_find']->learning_year }}"
                          required autocomplete="learning_year" autofocus placeholder="พ.ศ."> 
                          @error('learning_year')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>

                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="learning_publishing_agency"> หน่วยงานจัดทำ <span class="text-danger">*</span></label>
                          <input id="learning_publishing_agency" type="text" class="form-control form-control-lg @error('learning_publishing_agency') invalid @enderror" name="learning_publishing_agency"  
                          value="{{ $data['learning_find']->learning_publishing_agency }}"
                          required autocomplete="learning_publishing_agency" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('learning_publishing_agency')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 

                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="link_vdo"> Link Youtube </label>
                          <input id="link_vdo" type="url" class="form-control form-control-lg @error('link_vdo') invalid @enderror" name="link_vdo"  
                          value="{{ $data['learning_find']->link_vdo }}"
                          autocomplete="link_vdo" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('link_vdo')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                        
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="learning_meta_title"> Learning Meta Title </label>
                          <input id="learning_meta_title" type="text" class="form-control form-control-lg @error('learning_meta_title') invalid @enderror" name="learning_meta_title"  
                          value="{{ $data['learning_find']->learning_meta_title }}"
                          autocomplete="learning_meta_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('learning_meta_title')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="learning_meta_description"> Learning Meta Description </label>
                          <input id="learning_meta_description" type="text" class="form-control form-control-lg @error('learning_meta_description') invalid @enderror" name="learning_meta_description"  
                          value="{{ $data['learning_find']->learning_meta_description }}"
                          autocomplete="learning_meta_description" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('learning_meta_description')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="learning_meta_keyword"> Learning Meta Keyword </label>
                          <input id="learning_meta_keyword" type="text" class="form-control form-control-lg @error('learning_meta_keyword') invalid @enderror" name="learning_meta_keyword"  
                          value="{{ $data['learning_find']->learning_meta_keyword }}"
                          autocomplete="learning_meta_keyword" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('learning_meta_keyword')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div> 
    
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>  
                          <div class="cc-selector">  
                            <div class="cc-selector"> 
                            <input id="status1" type="radio" name="status" value="0" {{ $data['learning_find']->deleted_at == true ? $data['learning_find']->deleted_at == 0 ? "checked" : ""  : "checked"  }}/>
                            <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>  

                            <input id="status2" type="radio" name="status" value="1" {{ $data['learning_find']->deleted_at == 1 ? "checked" : "" }}/>
                            <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label> 
                          </div> 
                          </div> 
                        </div> 
                        <div class="col-md-12 form-group">  
                          <div class="d-flex">
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
                              <input type="hidden" id="file_upload_pdf_hdf" name="file_upload_pdf_hdf" value="{{ $data['learning_find']->learning_file_pdf }}">
                            </div>
                            @if(!empty($data['learning_find']->learning_file_pdf))
                              <a href="javascript: void(0);" data-file="{{ $data['learning_find']->learning_file_pdf }}" class="h2 m-0 text-danger" id="close-pdf"><i class="fe-trash-2"></i></a> 
                            @endif
                          </div>
                          <span class="mt-1 ml-1" style="font-size: 10px;"> {{ $data['learning_find']->learning_file_pdf }} </span>
                          @error('file_upload_pdf')  
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror 
                        </div>

                        <div class="col-md-6 form-group"> 
                          <label for="file_upload"> รูปแสดงผลการแชร์ Thumb <span class="text-danger">*</span></label>
                          <div class="img-file-upload-1"> 
                            <img src="{{ asset('images/learning').'/'.$data['learning_find']->learning_image_thumb_desktop }}" class="event-icon" style="width: 150px; border: 1px solid #ddd;"> 
                          </div>
                          <div class="mt-1 mb-1"> Size image 830*1170  2MB. </div>
                          <input id="file_upload" type="file" class="@error('file_upload') invalid @enderror" name="file_upload"  
                          value="{{ old('file_upload') }}"
                          autocomplete="file_upload" autofocus> 
                          <input type="hidden" id="file_upload_hdf" name="file_upload_hdf" value="{{ $data['learning_find']->learning_image_thumb_desktop }}">
                          @error('file_upload') 
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>
                        <div class="col-md-6 form-group"> 
                          <label for="file_upload_dektop"> รูปแสดงผลบน Web <span class="text-danger">*</span></label>
                          <div class="img-file-upload-2"> 
                            <img src="{{ asset('images/learning').'/'.$data['learning_find']->learning_image_desktop }}" class="event-icon" style="width: 150px; border: 1px solid #ddd;"> 
                          </div>
                          <div class="mt-1 mb-1"> Size image 830*1170  2MB. </div>
                          <input id="file_upload_dektop" type="file" class="@error('file_upload_dektop') invalid @enderror" name="file_upload_dektop"  
                          value="{{ old('file_upload_dektop') }}"
                          autocomplete="file_upload_dektop" autofocus> 
                          <input type="hidden" id="file_upload_dektop_hdf" name="file_upload_dektop_hdf" value="{{ $data['learning_find']->learning_image_desktop }}">
                          @error('file_upload_dektop') 
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>   
                      </div>
                    </div> 
                    <div class="col-md-7"> 
                      <label for="file_text">รายละเอียดแหล่งเรียนรู้ <span class="text-danger">*</span></label>
                      <div class="file_text"><?php echo file_get_contents(storage_path().'/app/'.$data['learning_find']->file_text); ?></div>
                      <input type="hidden" id="file_text" name="file_text" value="{{ $data['learning_find']->file_text }}"> 
                      <input type="hidden" id="file_text_hdfs" name="file_text_hdfs" value="{{ $data['learning_find']->file_text }}">
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
                      <a href="{{ route('learning.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                      <button type="button" class="btn btn-lg btn-danger waves-effect waves-light" id="close" data-id="{{ $data['learning_find']->id }}"> 
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
  $('#learning_category').select2();
  $('#learning_status').select2();
  $('.file_text').summernote({
    height: 820,                
    minHeight: null, 
    maxHeight: null,  
    focus: false 
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
          $.post("{{ route('close.learning.pdf') }}", {
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
          $.post("{{ route('close.learning') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              location.href = "{{ route('learning.list') }}";
            }
          })
          .fail(function(xhr, status, error) { 
            alert('An error occurred, please try again.'); 
            location.reload();
          });  
        } else {
          vthis[0].innerHTML='<i class="mdi mdi-delete"></i> ยกเลิกข้อมูล';  
        }
    }); 
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
  $( "form" ).submit(function( event ) {  
    var sum_val =$(".file_text").summernote('code'); 
    $('input[name=file_text]').val(sum_val);
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 
</script>
@endsection

