<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use DataTables;  
use App\Models\monkeygeniuses_activity_conservation;
use App\Models\acticonservation_gallery; 
use Illuminate\Support\Facades\Storage;

class ActiconservationCortroller extends Controller
{
    public function acticonservationlist()
    {     
        $data=array(); 
        return view('admin.acticonservation.acticonser_list', compact('data'));
    }  

    public function acticonservationadd()
    {
        $data=array(); 
        return view('admin.acticonservation.acticonser_add', compact('data'));
    }

    public function acticonservationedit($get_id)
    {
        $data=array( 
            "acticonservation_gallery" => acticonservation_gallery::where('deleted_at', 0)->where('acticonservation_id', $get_id)->get(),
            "acticonservation_find" => monkeygeniuses_activity_conservation::find($get_id),
        );  
        return view('admin.acticonservation.acticonser_edit', compact('data'));
    }  


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $date)
    {   
        $keywrod_sql=""; $status_sql=""; $date_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and monkeygeniuses_activity_conservations.acticonservation_title LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and monkeygeniuses_activity_conservations.deleted_at = ".$status.""; 
        }

        if(isset($date)){ 
            $date_sql=" and (monkeygeniuses_activity_conservations.created_at BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59')";  
        } 
        
        $data = DB::select('select * 
        from `monkeygeniuses_activity_conservations` 
        where monkeygeniuses_activity_conservations.id != "" 
        '.$keywrod_sql.' '.$status_sql.' '.$date_sql.'
        order by monkeygeniuses_activity_conservations.id DESC'); 

        return $data;
    }

    public function datatableActiconservation(Request $request)
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
        ->addColumn('acticonservation_title', function($row){    
            $img='<img src="'.asset('images/acticonservation').'/'.$row->acticonservation_image_thumb_desktop.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
            return '<a href="'.route('acticonservation.edit', [$row->id]).'"> '.$img.$row->acticonservation_title.'</a>';
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
                $html='<a href="'.route('acticonservation.edit', [$row->id]).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                return $html;
            })  
            ->rawColumns(['id','acticonservation_title', 'created_at', 'deleted_at', 'bntManger'])
            ->make(true);
        } 
    }

    public function closeActiconservation(Request $request)
    {
        if(isset($request)){ 
            $data=monkeygeniuses_activity_conservation::find($request->id);  
            $uploade_location = 'images/acticonservation/';  
            $uploade_location_pdf = 'images/acticonservation/pdf/';  
            if(!empty($data->file_pdf)){
                unlink($uploade_location_pdf.$data->file_pdf);
            }
            if(!empty($data->acticonservation_image_desktop) && !empty($data->acticonservation_image_thumb_desktop)){
                unlink($uploade_location.$data->acticonservation_image_desktop);
                unlink($uploade_location.$data->acticonservation_image_thumb_desktop);
            }

            if(!empty($data->acticonservation_file_text)){
                unlink(storage_path().'/app/'.$data->acticonservation_file_text); 
            }

            $data=DB::table('monkeygeniuses_activity_conservations')
            ->where('monkeygeniuses_activity_conservations.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function saveActiconservation(Request $request)
    {     
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'acticonservation_title' => ['required', 'string', 'max:255'], 
                    'acticonservation_intro' => ['required', 'string', 'max:255'],   
                    'acticonservation_file_text' => ['required'],  
 
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
                $file_text="acticonservation-".hexdec(uniqid()).".text";  
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully."; 
                $file_name=$request->file_upload_hdf; 
                $file_name_decktop=$request->file_upload_dektop_hdf;
                $file_name_pdf=$request->file_upload_pdf_hdf;
                $file_text=$request->acticonservation_file_text_hdfs;
            }

            if(!empty($request->acticonservation_file_text)){  
                Storage::disk('local')->put($file_text, $request->acticonservation_file_text);
            } 

            if($request->file('file_upload_pdf')){
                if(!empty($request->file('file_upload_pdf'))){ 
                    $uploade_location_pdf = 'images/acticonservation/pdf/';

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
                    $uploade_location = 'images/acticonservation/';

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
                    $uploade_location_dektop = 'images/acticonservation/';  

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
                'acticonservation_title'  => $request->acticonservation_title,    
                'acticonservation_intro'  => $request->acticonservation_intro,
                'acticonservation_slug'  => $request->acticonservation_slug,     
                'acticonservation_file_text' => $file_text,  
                'file_pdf' => $file_name_pdf, 
                
                'acticonservation_meta_title'       => $request->acticonservation_meta_title, 
                'acticonservation_meta_description' => $request->acticonservation_meta_description, 
                'acticonservation_meta_keyword'     => $request->acticonservation_meta_keyword,  
   
                'acticonservation_image_thumb_desktop' => $file_name, 
                'acticonservation_image_desktop' => $file_name_decktop, 
                
                'acticonservation_date'  => new \DateTime(),  
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),  
            );

            if($request->statusData=="C"){
                $get_id=DB::table('monkeygeniuses_activity_conservations')->insertGetId($data);  
            } else if($request->statusData=="U"){
                $get_id=$request->id;
                DB::table('monkeygeniuses_activity_conservations')
                ->where('monkeygeniuses_activity_conservations.id', $request->id)
                ->update($data);   
            } 

            if($request->file('file_upload_galleries')){
                if(count($request->file('file_upload_galleries'))>0){
                    $uploade_location_galleries = 'images/acticonservation/galleries/';
                    if($request->statusData=="U"){ 
                        $galleries=DB::table('acticonservation_galleries')->where('acticonservation_galleries.acticonservation_id', $get_id)->get();  
                        if(count($galleries)>0){
                            foreach($galleries as $row){
                                unlink($uploade_location_galleries.$row->image);
                            }
                        } 
                        DB::table('acticonservation_galleries')->where('acticonservation_galleries.acticonservation_id', $get_id)->delete(); 
                    }
                    $index=1;
                    foreach($request->file('file_upload_galleries') as $key=>$row){ 
                        $img_galleries = $request->file('file_upload_galleries')[$key];
                        $img_galleries_gen = hexdec(uniqid());
                        $img_galleries_ext = strtolower($img_galleries->getClientOriginalExtension()); 
                        $img_galleries_name = $img_galleries_gen.'.'.$img_galleries_ext;
                        //============Uploade Imgage galleries=============// 
                        $img_galleries->move($uploade_location_galleries, $img_galleries_name);  
                        $itmes_img[$index]['acticonservation_id']   =  $get_id;
                        $itmes_img[$index]['image']         =  $img_galleries_name; 
                        $itmes_img[$index]['ip_address']    =  $request->ip();
                        $itmes_img[$index]['created_at']    =  new \DateTime();
                        $index++;
                    }
                    DB::table('acticonservation_galleries')->insert($itmes_img);
                }
            } 

            if($request->statusData=="C"){ 
                return redirect()->route('acticonservation.add')->with('success', $msg);  
            } else if($request->statusData=="U"){ 
                return redirect()->route('acticonservation.edit', [$request->id])->with('success', $msg); 
            }   
        } 
    }

    public function closeActiconservationPdf(Request $request)
    {
        if(isset($request)){ 
            $uploade_location_pdf = 'images/acticonservation/pdf/';  
            $data_pdf=array("file_pdf" => NULL);
            $data=DB::table('monkeygeniuses_activity_conservations')
            ->where('monkeygeniuses_activity_conservations.id', $request->id)
            ->update($data_pdf); 
            if(!empty($request->file)){
                unlink($uploade_location_pdf.$request->file);  
            }
        }  
        return $data;
    }

    public function closeActiconservationGalleries(Request $request)
    {
        if(isset($request)){  
            $uploade_location_galleries='images/acticonservation/galleries/'; 
            $galleries=DB::table('acticonservation_galleries')->where('acticonservation_galleries.acticonservation_id', $request->id)->get();  
            if(count($galleries)>0){
                foreach($galleries as $row){
                    unlink($uploade_location_galleries.$row->image);
                }
            }  
            $data=DB::table('acticonservation_galleries')->where('acticonservation_galleries.acticonservation_id', $request->id)->delete();
        }  
        return $data;
    } 
}
