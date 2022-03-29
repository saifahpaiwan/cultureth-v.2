@extends('layouts.app-front')
@section('meta')  
   
@endsection
@section('style')   
<style>  
    .hero {
        background: -webkit-gradient(linear, left top, left bottom, from(rgba(69, 57, 71, 0.7)), to(rgba(69, 57, 71, 0.9))), url("{{ asset('images/hero4.jpg') }}") center/cover repeat;
        background: linear-gradient(rgba(69, 57, 71, 0.7), rgba(69, 57, 71, 0.9)), url("{{ asset('images/hero4.jpg') }}") center/cover repeat;
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
                <h1 class="display-4"> แหล่งเรียนรู้ </h1> 
            </div>
        </section>
        <section class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-filter"> 
                        <form method="GET" action="{{ route('learning') }}"> 
                            <div class="row"> 
                                <div class="col-md-5"> 
                                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="ชื่อแหล่งเรียนรู้">
                                </div>
                                <div class="col-md-3"> 
                                    <select class="form-control" id="year" name="year">
                                        <option value="">ปี พ.ศ.</option> 
                                        @for($Y=2550; $Y<=(date('Y')+543); $Y++)
                                            <option value="{{$Y}}">{{$Y}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4"> 
                                    <button class="btn" type="submit"> ค้นหา </button>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
 
            <div class="row p-3 px-md-5"> 
                <div class="col-md-12"> 
                    @if(isset($data['Query_learning']))
                        @if(count($data['Query_learning'])>0)
                            @foreach($data['Query_learning'] as $row)
                                <div class="row box-list mb-3"> 
                                    <div class="col-12 col-sm-2 p-1"> 
                                        <img  src="{{ asset('images/learning').'/'.$row->learning_image_desktop }}" class="img-fluid">
                                    </div>
                                    <div class="col-12 col-sm-10 p-1"> 
                                        <h4 class="white-space-normal-1"> {{ $row->learning_title }} </h4>
                                        <div class="mb-2 white-space-normal-1"> <b class="">ประเภทแหล่งเรียนรู้ : </b>	 {{ $row->categories_name }} </div>
                                        <div class="mb-2 white-space-normal-1"> <b class="">สถานที่ตั้ง : </b>	 {{ $row->learning_location }} </div>
                                        <div class="mb-2 white-space-normal-1"> <b class="">ปี พ.ศ. : </b>     {{ $row->learning_year }} </div>
                                        <div class="mb-2 white-space-normal-1"> <b class="">หน่วยงานที่จัดทำ : </b>  {{ $row->learning_publishing_agency }}</div> 
                                        <div class="font-13"> <i class="fe-calendar"></i> {{ date("d/m/Y", strtotime($row->created_at)) }} </div>
                                        <a href="{{ route('learning.view', [$row->id]) }}" class="btn mt-1"> ดูรายละเอียด </a> 
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <h4 class="text-center"> ไม่พบข้อมูล <h4>
                        @endif
                    @endif
                </div> 
                <div class="col-md-12 p-0">  
                    <div class="d-flex justify-content-end">
                        {!! $data['Query_learning']->links() !!}
                    </div> 
                </div>
            </div>
        </section> 
    </div>
@endsection
@section('script')   
<script> 
 
</script>
@endsection

