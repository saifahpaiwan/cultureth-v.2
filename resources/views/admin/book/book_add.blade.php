@extends('layouts.app')
@section('style')      
  <link href="{{ asset('admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />   
  <link href="{{ asset('admin/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />  
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
                <h4 class="page-title"> <i class="fe-book"></i> หนังสือและวารสารสำนัก  </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">   
                  <div class="col-md-12"> 
                    <h5 class="m-0"> เพิ่มหนังสือและวารสารสำนัก 
                    <a href="{{ route('book.list') }}" class="float-right"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
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
                <form method="POST" action="{{ route('save.book') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="C">
                  <input type="hidden" id="id" name="id" value="">

                  <div class="row"> 
                    <div class="col-md-5 form-group"> 
                      <label class="ml-1" for="book_title"> ชื่อหนังสือและวารสารสำนัก <span class="text-danger">*</span></label>
                      <input id="book_title" type="text" class="form-control form-control-lg @error('book_title') invalid @enderror" name="book_title"  
                      value="{{ old('book_title') }}"
                      required autocomplete="book_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('book_title')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-5 form-group"> 
                      <label class="ml-1" for="book_author"> ชื่อผู้แต่ง <span class="text-danger">*</span></label>
                      <input id="book_author" type="text" class="form-control form-control-lg @error('book_author') invalid @enderror" name="book_author"  
                      value="{{ old('book_author') }}"
                      required autocomplete="book_author" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('book_author')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-2 form-group"> 
                      <label class="ml-1" for="book_type"> ประเภทหนังสือ <span class="text-danger">*</span></label> 
                      <select id="book_type" name="book_type" class="form-control  @error('book_type') invalid @enderror" data-toggle="select2" required>
                        <option value=""> เลือกประเภทหนังสือ </option>
                        <option value="1"> หนังสือ </option> 
                        <option value="2"> วารสารสำนักงาน </option> 
                      </select>  
                      @error('book_type')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    
                    <div class="col-md-10 form-group"> 
                      <label class="ml-1" for="book_keyword"> คำสำคัญ <span class="text-danger">*</span></label>
                      <input id="book_keyword" type="text" class="form-control form-control-lg @error('book_keyword') invalid @enderror" name="book_keyword"  
                      value="{{ old('book_keyword') }}"
                      required autocomplete="book_keyword" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('book_keyword')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    
                    <div class="col-md-2 form-group"> 
                      <label class="ml-1" for="book_year"> ปีที่แต่ง <span class="text-danger">*</span></label>
                      <input id="book_year" type="number" class="form-control form-control-lg @error('book_year') invalid @enderror" name="book_year"  
                      value="{{ old('book_year') }}"
                      required autocomplete="book_year" autofocus placeholder="พ.ศ."> 
                      @error('book_year')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>

                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="book_publishing_agency"> หน่วยงานที่จัดพิมพ์ <span class="text-danger">*</span></label>
                      <input id="book_publishing_agency" type="text" class="form-control form-control-lg @error('book_publishing_agency') invalid @enderror" name="book_publishing_agency"  
                      value="{{ old('book_publishing_agency') }}"
                      required autocomplete="book_publishing_agency" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('book_publishing_agency')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    
                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="book_meta_title"> Book Meta Title </label>
                      <input id="book_meta_title" type="text" class="form-control form-control-lg @error('book_meta_title') invalid @enderror" name="book_meta_title"  
                      value="{{ old('book_meta_title') }}"
                      autocomplete="book_meta_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('book_meta_title')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="book_meta_description"> Book Meta Description </label>
                      <input id="book_meta_description" type="text" class="form-control form-control-lg @error('book_meta_description') invalid @enderror" name="book_meta_description"  
                      value="{{ old('book_meta_description') }}"
                      autocomplete="book_meta_description" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('book_meta_description')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="book_meta_keyword"> Book Meta Keyword </label>
                      <input id="book_meta_keyword" type="text" class="form-control form-control-lg @error('book_meta_keyword') invalid @enderror" name="book_meta_keyword"  
                      value="{{ old('book_meta_keyword') }}"
                      autocomplete="book_meta_keyword" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('book_meta_keyword')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
 
                    <div class="col-md-3 form-group"> 
                      <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>  
                      <div class="cc-selector"> 
                        <input id="status1" type="radio" name="status" value="0" {{ old('status') == true ? old('status') == 0 ? "checked" : ""  : "checked"  }}/>
                        <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>  

                        <input id="status2" type="radio" name="status" value="1" {{ old('status') == 1 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label> 
                      </div> 
                    </div> 
                    <div class="col-md-9 form-group">  
                      <div class="d-flex mt-3">
                        <div>
                          <div class="img-file-upload-pdf"> 
                            <img src="{{ asset('images/pdf.png') }}" class="event-icon" style="width: 45px;"> 
                          </div> 
                        </div>
                        <div class="ml-2">
                          <div> อัพโหลดไฟล์ PDF ถ้ามี Size 30MB.</div>
                          <input id="file_upload_pdf" type="file" class="@error('file_upload_pdf') invalid @enderror" name="file_upload_pdf"  
                          value="{{ old('file_upload_pdf') }}"
                          autocomplete="file_upload_pdf" autofocus> 
                          <input type="hidden" id="file_upload_pdf_hdf" name="file_upload_pdf_hdf" value="">
                        </div>
                      </div>
                      @error('file_upload_pdf') 
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>

                    <div class="col-md-3 form-group"> 
                      <label for="file_upload"> รูปแสดงผลการแชร์ Thumb <span class="text-danger">*</span></label>
                      <div class="img-file-upload-1"> 
                        <img src="{{ asset('images/no-img.png') }}" class="event-icon" style="width: 150px; border: 1px solid #ddd;"> 
                      </div>
                      <div class="mt-1 mb-1"> Size image 830*1170  2MB. </div>
                      <input id="file_upload" type="file" class="@error('file_upload') invalid @enderror" name="file_upload"  
                      value="{{ old('file_upload') }}"
                      required autocomplete="file_upload" autofocus> 
                      <input type="hidden" id="file_upload_hdf" name="file_upload_hdf" value="">
                      @error('file_upload') 
                        <span class="invalid-feedback" role="alert">
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="col-md-9 form-group"> 
                      <label for="file_upload_dektop"> รูปแสดงผลบน Web <span class="text-danger">*</span></label>
                      <div class="img-file-upload-2"> 
                        <img src="{{ asset('images/no-img.png') }}" class="event-icon" style="width: 150px; border: 1px solid #ddd;"> 
                      </div>
                      <div class="mt-1 mb-1"> Size image 830*1170  2MB. </div>
                      <input id="file_upload_dektop" type="file" class="@error('file_upload_dektop') invalid @enderror" name="file_upload_dektop"  
                      value="{{ old('file_upload_dektop') }}"
                      required autocomplete="file_upload_dektop" autofocus> 
                      <input type="hidden" id="file_upload_dektop_hdf" name="file_upload_dektop_hdf" value="">
                      @error('file_upload_dektop') 
                        <span class="invalid-feedback" role="alert">
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                        </span>
                      @enderror
                    </div>  

                  </div>
                  <hr>
                  <div class="row"> 
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('book.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
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
<script> 
  $('#book_type').select2();
  $('#book_status').select2();
 
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
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 
</script>
@endsection

