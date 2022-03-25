<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use DataTables;  
use App\Models\report_annual;
use Illuminate\Support\Facades\Storage;

class ReportannualController extends Controller
{
    public function annuallist()
    {     
        $data=array(); 
        return view('admin.annual.annual_list', compact('data'));
    }  

    public function annualadd()
    {
        $data=array(); 
        return view('admin.annual.annual_add', compact('data'));
    }

    public function annualedit($get_id)
    {
        $data=array( 
            "annual_find" => report_annual::find($get_id),
        );  
        return view('admin.annual.annual_edit', compact('data'));
    }  


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $date)
    {   
        $keywrod_sql=""; $status_sql=""; $date_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and report_annuals.annual_title LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and report_annuals.deleted_at = ".$status.""; 
        }

        if(isset($date)){ 
            $date_sql=" and (report_annuals.created_at BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59')";  
        } 
        
        $data = DB::select('select * 
        from `report_annuals` 
        where report_annuals.id != "" 
        '.$keywrod_sql.' '.$status_sql.' '.$date_sql.'
        order by report_annuals.id DESC'); 

        return $data;
    }

    public function datatableannual(Request $request)
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
        ->addColumn('annual_title', function($row){    
            $img='<img src="'.asset('images/annual').'/'.$row->annual_image_thumb_desktop.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
            return '<a href="'.route('annual.edit', [$row->id]).'"> '.$img.$row->annual_title.'</a>';
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
                $html='<a href="'.route('annual.edit', [$row->id]).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                return $html;
            })  
            ->rawColumns(['id','annual_title', 'created_at', 'deleted_at', 'bntManger'])
            ->make(true);
        } 
    }

    public function closeannual(Request $request)
    {
        if(isset($request)){ 
            $data=report_annual::find($request->id);  
            $uploade_location = 'images/annual/';  
            $uploade_location_pdf = 'images/annual/pdf/';  
            if(!empty($data->file_pdf)){
                unlink($uploade_location_pdf.$data->file_pdf);
            }
            if(!empty($data->annual_image_desktop) && !empty($data->annual_image_thumb_desktop)){
                unlink($uploade_location.$data->annual_image_desktop);
                unlink($uploade_location.$data->annual_image_thumb_desktop);
            }

            if(!empty($data->annual_file_text)){
                unlink(storage_path().'/app/'.$data->annual_file_text); 
            }

            $data=DB::table('report_annuals')
            ->where('report_annuals.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function saveannual(Request $request)
    {     
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'annual_title' => ['required', 'string', 'max:255'], 
                    'annual_intro' => ['required', 'string', 'max:255'],    
                    'annual_file_text' => ['required'],  
 
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
                $file_text="annual-".hexdec(uniqid()).".text";  
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully."; 
                $file_name=$request->file_upload_hdf; 
                $file_name_decktop=$request->file_upload_dektop_hdf;
                $file_name_pdf=$request->file_upload_pdf_hdf;
                $file_text=$request->annual_file_text_hdfs;
            }

            if(!empty($request->annual_file_text)){  
                Storage::disk('local')->put($file_text, $request->annual_file_text);
            } 


            if($request->file('file_upload_pdf')){
                if(!empty($request->file('file_upload_pdf'))){ 
                    $uploade_location_pdf = 'images/annual/pdf/';

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
                    $uploade_location = 'images/annual/';

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
                    $uploade_location_dektop = 'images/annual/';  

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
                'annual_title'  => $request->annual_title,    
                'annual_intro'  => $request->annual_intro,  
                'annual_file_text' => $file_text,  
                
                'annual_meta_title'       => $request->annual_meta_title, 
                'annual_meta_description' => $request->annual_meta_description, 
                'annual_meta_keyword'     => $request->annual_meta_keyword,  
   
                'annual_image_thumb_desktop' => $file_name, 
                'annual_image_desktop' => $file_name_decktop, 
                'file_pdf' => $file_name_pdf, 
                
                'annual_date'  => new \DateTime(),  
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),  
            );
 
            if($request->statusData=="C"){
                DB::table('report_annuals')->insert($data); 
                return redirect()->route('annual.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('report_annuals')
                ->where('report_annuals.id', $request->id)
                ->update($data);  
                return redirect()->route('annual.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }

    public function closeannualPdf(Request $request)
    {
        if(isset($request)){ 
            $uploade_location_pdf = 'images/annual/pdf/';  
            $data_pdf=array("file_pdf" => NULL);
            $data=DB::table('report_annuals')
            ->where('report_annuals.id', $request->id)
            ->update($data_pdf); 
            if(!empty($request->file)){
                unlink($uploade_location_pdf.$request->file);  
            }
        }  
        return $data;
    }
}
