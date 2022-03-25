<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use DataTables;  
use App\Models\slideshow;

class SlideshowCortroller extends Controller
{
    public function slideshowlist()
    {     
        $data=array(); 
        return view('admin.slideshow.slide_list', compact('data'));
    }  

    public function slideshowadd()
    {
        $data=array(); 
        return view('admin.slideshow.slide_add', compact('data'));
    }

    public function slideshowedit($get_id)
    {
        $data=array( 
            "slideshow_find" => slideshow::find($get_id),
        );  
        return view('admin.slideshow.slide_edit', compact('data'));
    }  


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $slide_type)
    {   
        $keywrod_sql=""; $status_sql=""; $slide_type_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and slideshows.title LIKE '%".$keywrod."%'";
        }

        if(isset($status)){  
            $status_sql=" and slideshows.deleted_at = ".$status.""; 
        }

        if(isset($slide_type)){  
            $slide_type_sql=" and slideshows.slide_type = ".$slide_type.""; 
        }

        $data = DB::select('select * 
        from `slideshows` 
        where slideshows.id != "" 
        '.$keywrod_sql.' '.$status_sql.' '.$slide_type_sql.'
        order by slideshows.id DESC'); 

        return $data;
    }

    public function datatableSlideshow(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable($request->keywrod, $request->status, $request->slide_type);
            // ===================QUERY-DATATABLE======================= // 
        return Datatables::of($data)
        ->addIndexColumn() 
        ->addColumn('slideshow_img', function($row){    
            $img='<img src="'.asset('images/slideshow').'/'.$row->image_thumb_desktop.'"  class="mr-2" height="50" style="border: 1px solid #ddd;">';
            return '<a href="'.route('slideshow.edit', [$row->id]).'"> '.$img.$row->title.'</a>';
        })   
        ->addColumn('slide_type', function($row){  
            $slide_type="";
            if($row->slide_type==1){
                $slide_type="สไลด์หลัก"; 
            } else if($row->slide_type==2){
                $slide_type="สื่อวิดิทัศน์"; 
            }
            return $slide_type;
        })  
        ->addColumn('slideshow_status', function($row){  
            $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
            if($row->deleted_at==1){
                $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>'; 
            }
            return $deleted_at;
        })  
        ->addColumn('bntManger', function($row){      
            $html='<a href="'.route('slideshow.edit', [$row->id]).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
            $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
            return $html;
        })  
        ->rawColumns(['slideshow_img', 'slideshow_status', 'slide_type', 'bntManger'])
        ->make(true);
        } 
    }
 
    public function closeSlideshow(Request $request)
    {
        if(isset($request)){
            $data=slideshow::find($request->id); 
            $uploade_location = 'images/slideshow/'; 
            
            if(!empty($data->image_desktop) && !empty($data->image_thumb_desktop)){
                unlink($uploade_location.$data->image_desktop);
                unlink($uploade_location.$data->image_thumb_desktop);
            }

            $data=DB::table('slideshows')
            ->where('slideshows.id', $request->id)  
            ->delete();
        }  
        return $data;
    }
 
    public function saveSlideshow(Request $request)
    {  
        if(isset($request)){
            $validatedData = $request->validate(
                [   
                    'slideshow_type'  => ['required'],
                    'status' => ['required'], 
 
                    'file_upload' => 'image|mimes:jpeg,png,jpg|max:3072',
                    'file_upload_dektop' => 'image|mimes:jpeg,png,jpg|max:3072',
                ] 
            );  

            if($request->statusData=="C"){
                $dataType="created_at";
                $msg="Save data successfully."; 
                $file_name=NULL; 
                $file_name_decktop=NULL;
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully."; 
                $file_name=$request->file_upload_hdf; 
                $file_name_decktop=$request->file_upload_dektop_hdf;
            }
  
            if($request->file('file_upload')){
                if(!empty($request->file('file_upload'))){ 
                    $uploade_location = 'images/slideshow/';

                    if($request->statusData=="U" && $file_name!=""){ 
                        unlink($uploade_location.$file_name);
                    }

                    $file = $request->file('file_upload');
                    $file_gen = hexdec(uniqid());
                    $file_ext = strtolower($file->getClientOriginalExtension()); 
                    $file_name = $file_gen.'.'.$file_ext;
                    $file->move($uploade_location, $file_name); 
                } 
            }

            if($request->file('file_upload_dektop')){
                if(!empty($request->file('file_upload_dektop'))){
                    $uploade_location_dektop = 'images/slideshow/';  

                    if($request->statusData=="U" && $file_name_decktop!=""){
                        unlink($uploade_location_dektop.$file_name_decktop);
                    }

                    $file_dektop = $request->file('file_upload_dektop');
                    $file_gen_dektop = hexdec(uniqid());
                    $file_ext_dektop = strtolower($file_dektop->getClientOriginalExtension()); 
                    $file_name_decktop = $file_gen_dektop.'.'.$file_ext_dektop;
                    $file_dektop->move($uploade_location_dektop, $file_name_decktop); 
                } 
            } 

            $data=array(
                'title'  => $request->slideshow_title,  
                'slide_type'       => $request->slideshow_type,  
                'link'             => $request->slideshow_link,
                'image_thumb_desktop' => $file_name, 
                'image_desktop' => $file_name_decktop, 
  
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),  
            );
 
            if($request->statusData=="C"){
                DB::table('slideshows')->insert($data); 
                return redirect()->route('slideshow.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('slideshows')
                ->where('slideshows.id', $request->id)
                ->update($data);  
                return redirect()->route('slideshow.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }
}
