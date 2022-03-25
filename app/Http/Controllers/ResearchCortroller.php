<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use DataTables;  
use App\Models\monkeygeniuses_research;

class ResearchCortroller extends Controller
{
    public function researchlist()
    {     
        $data=array(); 
        return view('admin.research.research_list', compact('data'));
    }  

    public function researchadd()
    {
        $data=array(); 
        return view('admin.research.research_add', compact('data'));
    }

    public function researchedit($get_id)
    {
        $data=array( 
            "research_find" => monkeygeniuses_research::find($get_id),
        );  
        return view('admin.research.research_edit', compact('data'));
    }  


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $research_type)
    {   
        $keywrod_sql=""; $status_sql=""; $research_type_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and monkeygeniuses_researches.research_title LIKE '%".$keywrod."%'
            or monkeygeniuses_researches.research_name LIKE '%".$keywrod."%'
            or monkeygeniuses_researches.research_keyword LIKE '%".$keywrod."%'
            or monkeygeniuses_researches.research_publishing_agency LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and monkeygeniuses_researches.deleted_at = ".$status.""; 
        }

        if(isset($research_type)){  
            $research_type_sql=" and monkeygeniuses_researches.research_type = ".$research_type.""; 
        }

        $data = DB::select('select * 
        from `monkeygeniuses_researches` 
        where monkeygeniuses_researches.id != "" 
        '.$keywrod_sql.' '.$status_sql.' '.$research_type_sql.'
        order by monkeygeniuses_researches.id DESC'); 

        return $data;
    }

    public function datatableResearch(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable($request->keywrod, $request->status, $request->research_type);
            // ===================QUERY-DATATABLE======================= // 
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('id', function($row){    
            return $row->id;
        }) 
        ->addColumn('research_title', function($row){    
            $img='<img src="'.asset('images/research').'/'.$row->research_image_thumb_desktop.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
            return '<a href="'.route('research.edit', [$row->id]).'"> '.$img.$row->research_title.'</a>';
        })   
        ->addColumn('research_name', function($row){    
            return $row->research_name;
        })   
        ->addColumn('research_publishing_agency', function($row){    
            return $row->research_publishing_agency;
        })   
        ->addColumn('research_type', function($row){  
            $research_type="";
            if($row->research_type==1){
                $research_type="หนังสือ";
            } else  if($row->research_type==2){
                $research_type="วารสารสำนักงาน";
            }
            return $research_type;
        })   
        ->addColumn('deleted_at', function($row){  
            $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
            if($row->deleted_at==1){
                $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>'; 
            }
            return $deleted_at;
        })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('research.edit', [$row->id]).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                return $html;
            })  
            ->rawColumns(['id','research_title', 'research_name', 'research_publishing_agency', 'research_type', 'research_year', 'deleted_at', 'bntManger'])
            ->make(true);
        } 
    }

    public function closeResearch(Request $request)
    {
        if(isset($request)){
            $data=monkeygeniuses_research::find($request->id);
            $uploade_location_pdf = 'images/research/pdf/'; 
            $uploade_location = 'images/research/'; 
            if(!empty($data->research_file_pdf)){
                unlink($uploade_location_pdf.$data->research_file_pdf);
            }

            if(!empty($data->research_image_desktop) && !empty($data->research_image_thumb_desktop)){
                unlink($uploade_location.$data->research_image_desktop);
                unlink($uploade_location.$data->research_image_thumb_desktop);
            }

            $data=DB::table('monkeygeniuses_researches')
            ->where('monkeygeniuses_researches.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function closeResearchPdf(Request $request)
    {
        if(isset($request)){ 
            $uploade_location_pdf = 'images/research/pdf/';  
            $data_pdf=array("research_file_pdf" => NULL);
            $data=DB::table('monkeygeniuses_researches')
            ->where('monkeygeniuses_researches.id', $request->id)
            ->update($data_pdf); 
            if(!empty($request->file)){
                unlink($uploade_location_pdf.$request->file);  
            }
        }  
        return $data;
    }

    public function saveResearch(Request $request)
    {  
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'research_title' => ['required', 'string', 'max:255'],
                    'research_name' => ['required', 'string', 'max:255'],
                    'research_type' => ['required'],
                    'research_keyword' => ['required', 'string'],
                    'research_year' => ['required', 'max:255'],
                    'research_publishing_agency' =>['required', 'string', 'max:255'], 
                    
                    'status' => ['required'], 
                    'research_detial' => ['required', 'string'],

                    'file_upload_pdf' => ['mimes:pdf', 'max:50000'],
                    'file_upload' => 'image|mimes:jpeg,png,jpg|max:3072',
                    'file_upload_dektop' => 'image|mimes:jpeg,png,jpg|max:3072',
                ] 
            );  
             
            if($request->statusData=="C"){
                $dataType="created_at";
                $msg="Save data successfully.";
                $file_name_pdf=NULL;
                $file_name=NULL; 
                $file_name_decktop=NULL;
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully.";
                $file_name_pdf=$request->file_upload_pdf_hdf;
                $file_name=$request->file_upload_hdf; 
                $file_name_decktop=$request->file_upload_dektop_hdf;
            }
            
            if($request->file('file_upload_pdf')){
                if(!empty($request->file('file_upload_pdf'))){ 
                    $uploade_location_pdf = 'images/research/pdf/';

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
                    $uploade_location = 'images/research/';

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
                    $uploade_location_dektop = 'images/research/';  

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
                'research_title'  => $request->research_title, 
                'research_name' => $request->research_name, 
                'research_type' => $request->research_type, 
                'research_keyword' => $request->research_keyword, 
                'research_year' => $request->research_year, 
                'research_publishing_agency' => $request->research_publishing_agency,  
                'research_detial' => $request->research_detial,

                'research_meta_title' => $request->research_meta_title, 
                'research_meta_description' => $request->research_meta_description, 
                'research_meta_keyword' => $request->research_meta_keyword,  
  
                'research_file_pdf' => $file_name_pdf, 
                'research_image_thumb_desktop' => $file_name, 
                'research_image_desktop' => $file_name_decktop, 
 
                'research_date' => new \DateTime(),  
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),  
            );
 
            if($request->statusData=="C"){
                DB::table('monkeygeniuses_researches')->insert($data); 
                return redirect()->route('research.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('monkeygeniuses_researches')
                ->where('monkeygeniuses_researches.id', $request->id)
                ->update($data);  
                return redirect()->route('research.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }
}
