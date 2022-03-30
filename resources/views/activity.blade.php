@extends('layouts.app-front')
@section('meta')  
   
@endsection
@section('style')   
<style>  
    .hero {
        background: -webkit-gradient(linear, left top, left bottom, from(rgba(69, 57, 71, 0.7)), to(rgba(69, 57, 71, 0.9))), url("{{ asset('images/hero2.jpg') }}") center/cover repeat;
        background: linear-gradient(rgba(69, 57, 71, 0.7), rgba(69, 57, 71, 0.9)), url("{{ asset('images/hero2.jpg') }}") center/cover repeat;
    } 
</style> 
@endsection
@section('content') 
    <div class="container bg-white">  
        <section class="hero">
            <div class="hero-texts">
                <h1 class=""> โครงการ/กิจกรรม </h1> 
            </div>
        </section>
        <section class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-filter"> 
                        <form method="GET" action="{{ route('activity') }}"> 
                            <div class="row"> 
                                <div class="col-md-5"> 
                                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="ชื่อข่าวกิจกรรม">
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
                @if(isset($data['Query_activity']))
                    @if(count($data['Query_activity'])>0)
                        @foreach($data['Query_activity'] as $row) 
                            <div class="col-md-3"> 
                                <div class="card p-2">
                                    <img  src="{{ asset('images/activity').'/'.$row->activity_image_desktop }}" class="img-fluid"> 
                                    <div class="mt-2 mb-1 white-space-normal"> {{ $row->activity_title }} </div>   
                                    <div class="font-13"> <i class="fe-calendar"></i> {{ date("d/m/Y", strtotime($row->created_at)) }} </div>
                                    <a href="{{ route('activity.view', [$row->id]) }}" class="btn mt-1"> อ่านเพิ่มเติม </a> 
                                </div>
                            </div> 
                        @endforeach
                    @else
                    <h4 class="text-center"> ไม่พบข้อมูล <h4>
                    @endif
                @endif 
                <div class="col-md-12 p-0">  
                    <div class="d-flex justify-content-end">
                        {!! $data['Query_activity']->links() !!}
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

