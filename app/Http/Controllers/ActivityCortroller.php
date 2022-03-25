<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use DataTables;  
use App\Models\monkeygeniuses_activity;
use App\Models\activity_gallery; 
use Illuminate\Support\Facades\Storage;

class ActivityCortroller extends Controller
{
    public function activitylist()
    {     
        $data=array(); 
        return view('admin.activity.acti_list', compact('data'));
    }  

    public function activityadd()
    {
        $data=array(); 
        return view('admin.activity.acti_add', compact('data'));
    }

    public function activityedit($get_id)
    {
        $data=array( 
            "activity_gallery" => activity_gallery::where('deleted_at', 0)->where('activity_id', $get_id)->get(),
            "activity_find" => monkeygeniuses_activity::find($get_id),
        );  
        return view('admin.activity.acti_edit', compact('data'));
    }  


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $date)
    {   
        $keywrod_sql=""; $status_sql=""; $date_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and monkeygeniuses_activities.activity_title LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and monkeygeniuses_activities.deleted_at = ".$status.""; 
        }

        if(isset($date)){ 
            $date_sql=" and (monkeygeniuses_activities.created_at BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59')";  
        } 
        
        $data = DB::select('select * 
        from `monkeygeniuses_activities` 
        where monkeygeniuses_activities.id != "" 
        '.$keywrod_sql.' '.$status_sql.' '.$date_sql.'
        order by monkeygeniuses_activities.id DESC'); 

        return $data;
    }

    public function datatableActivity(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable($request->keywrod, $request->status, $request->date);
            // ===================QUERY-DATATABLE======================= // 
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('id', function($row){    
            return $row->id;
        }) 
        ->addColumn('activity_title', function($row){    
            $img='<img src="'.asset('images/activity').'/'.$row->activity_image_thumb_desktop.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
            return '<a href="'.route('activity.edit', [$row->id]).'"> '.$img.$row->activity_title.'</a>';
        })   
        ->addColumn('created_at', function($row){    
            return $row->created_at;
        })    
        ->addColumn('deleted_at', function($row){  
            $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
            if($row->deleted_at==1){
                $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>'; 
            }
            return $deleted_at;
        })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('activity.edit', [$row->id]).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                return $html;
            })  
            ->rawColumns(['id','activity_title', 'created_at', 'deleted_at', 'bntManger'])
            ->make(true);
        } 
    }

    public function closeActivity(Request $request)
    {
        if(isset($request)){ 
            $data=monkeygeniuses_activity::find($request->id);  
            $uploade_location = 'images/activity/';  
            $uploade_location_pdf = 'images/activity/pdf/';  
            if(!empty($data->file_pdf)){
                unlink($uploade_location_pdf.$data->file_pdf);
            }
            if(!empty($data->activity_image_desktop) && !empty($data->activity_image_thumb_desktop)){
                unlink($uploade_location.$data->activity_image_desktop);
                unlink($uploade_location.$data->activity_image_thumb_desktop);
            }

            if(!empty($data->activity_file_text)){
                unlink(storage_path().'/app/'.$data->activity_file_text); 
            }

            $data=DB::table('monkeygeniuses_activities')
            ->where('monkeygeniuses_activities.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function saveActivity(Request $request)
    {      
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'activity_title' => ['required', 'string', 'max:255'], 
                    'activity_intro' => ['required', 'string', 'max:255'],  
                    'activity_file_text' => ['required'],  
 
                    'file_upload_pdf' => ['mimes:pdf', 'max:50000'],
                    'file_upload' => 'image|mimes:jpeg,png,jpg|max:3072',
                    'file_upload_dektop' => 'image|mimes:jpeg,png,jpg|max:3072',
                ] 
            );  
             
            if($request->statusData=="C"){
                $dataType="created_at";
                $msg="Save data successfully.";  
                $file_name=NULL; 
                $file_name_decktop=NULL;
                $file_name_pdf=NULL;
                $file_text="acti-".hexdec(uniqid()).".text";  
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully."; 
                $file_name=$request->file_upload_hdf; 
                $file_name_decktop=$request->file_upload_dektop_hdf;
                $file_name_pdf=$request->file_upload_pdf_hdf;
                $file_text=$request->activity_file_text_hdfs;
            }

            if(!empty($request->activity_file_text)){  
                Storage::disk('local')->put($file_text, $request->activity_file_text);
            } 

            if($request->file('file_upload_pdf')){
                if(!empty($request->file('file_upload_pdf'))){ 
                    $uploade_location_pdf = 'images/activity/pdf/';

                    if($request->statusData=="U" && $file_name_pdf!=""){
                        unlink($uploade_location_pdf.$file_name_pdf);
                    }

                    $file_pdf = $request->file('file_upload_pdf');
                    $file_gen_pdf = hexdec(uniqid());
                    $file_ext_pdf = strtolower($file_pdf->getClientOriginalExtension()); 
                    $file_name_pdf = $file_gen_pdf.'.'.$file_ext_pdf;
                    $file_pdf->move($uploade_location_pdf, $file_name_pdf); 
                } 
            }
 
            if($request->file('file_upload')){
                if(!empty($request->file('file_upload'))){ 
                    $uploade_location = 'images/activity/';

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
                    $uploade_location_dektop = 'images/activity/';  

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
                'activity_title'  => $request->activity_title,    
                'activity_intro'  => $request->activity_intro,    
                'activity_file_text' => $file_text,  
                'file_pdf' => $file_name_pdf, 
                
                'activity_meta_title'       => $request->activity_meta_title, 
                'activity_meta_description' => $request->activity_meta_description, 
                'activity_meta_keyword'     => $request->activity_meta_keyword,  
   
                'activity_image_thumb_desktop' => $file_name, 
                'activity_image_desktop' => $file_name_decktop, 
                
                'activity_date'  => new \DateTime(),  
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),  
            );
 
            if($request->statusData=="C"){
                $get_id=DB::table('monkeygeniuses_activities')->insertGetId($data);  
            } else if($request->statusData=="U"){
                $get_id=$request->id;
                DB::table('monkeygeniuses_activities')
                ->where('monkeygeniuses_activities.id', $request->id)
                ->update($data);   
            } 

            if($request->file('file_upload_galleries')){
                if(count($request->file('file_upload_galleries'))>0){
                    $uploade_location_galleries = 'images/activity/galleries/';
                    if($request->statusData=="U"){ 
                        $galleries=DB::table('activity_galleries')->where('activity_galleries.activity_id', $get_id)->get();  
                        if(count($galleries)>0){
                            foreach($galleries as $row){
                                unlink($uploade_location_galleries.$row->image);
                            }
                        } 
                        DB::table('activity_galleries')->where('activity_galleries.activity_id', $get_id)->delete(); 
                    }
                    $index=1;
                    foreach($request->file('file_upload_galleries') as $key=>$row){ 
                        $img_galleries = $request->file('file_upload_galleries')[$key];
                        $img_galleries_gen = hexdec(uniqid());
                        $img_galleries_ext = strtolower($img_galleries->getClientOriginalExtension()); 
                        $img_galleries_name = $img_galleries_gen.'.'.$img_galleries_ext;
                        //============Uploade Imgage galleries=============// 
                        $img_galleries->move($uploade_location_galleries, $img_galleries_name);  
                        $itmes_img[$index]['activity_id']   =  $get_id;
                        $itmes_img[$index]['image']         =  $img_galleries_name; 
                        $itmes_img[$index]['ip_address']    =  $request->ip();
                        $itmes_img[$index]['created_at']    =  new \DateTime();
                        $index++;
                    }
                    DB::table('activity_galleries')->insert($itmes_img);
                }
            } 

            if($request->statusData=="C"){ 
                return redirect()->route('activity.add')->with('success', $msg);  
            } else if($request->statusData=="U"){ 
                return redirect()->route('activity.edit', [$request->id])->with('success', $msg); 
            }  
        } 
    }

    public function closeActivityPdf(Request $request)
    {
        if(isset($request)){ 
            $uploade_location_pdf = 'images/activity/pdf/';  
            $data_pdf=array("file_pdf" => NULL);
            $data=DB::table('monkeygeniuses_activities')
            ->where('monkeygeniuses_activities.id', $request->id)
            ->update($data_pdf); 
            if(!empty($request->file)){
                unlink($uploade_location_pdf.$request->file);  
            }
        }  
        return $data;
    }

    public function closeActivityGalleries(Request $request)
    {
        if(isset($request)){  
            $uploade_location_galleries='images/activity/galleries/'; 
            $galleries=DB::table('activity_galleries')->where('activity_galleries.activity_id', $request->id)->get();  
            if(count($galleries)>0){
                foreach($galleries as $row){
                    unlink($uploade_location_galleries.$row->image);
                }
            }  
            $data=DB::table('activity_galleries')->where('activity_galleries.activity_id', $request->id)->delete();
        }  
        return $data;
    } 
}
