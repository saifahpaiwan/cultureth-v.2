<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use DataTables;  
use App\Models\monkeygeniuses_journal;
use Illuminate\Support\Facades\Storage; 

class JournalCortroller extends Controller
{
    public function journallist()
    {     
        $data=array(); 
        return view('admin.journal.jou_list', compact('data'));
    }  

    public function journaladd()
    {
        $data=array(); 
        return view('admin.journal.jou_add', compact('data'));
    }

    public function journaledit($get_id)
    {
        $data=array( 
            "journal_find" => monkeygeniuses_journal::find($get_id),
        );  
        return view('admin.journal.jou_edit', compact('data'));
    }  


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status)
    {   
        $keywrod_sql=""; $status_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and monkeygeniuses_journals.journal_title LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and monkeygeniuses_journals.deleted_at = ".$status.""; 
        }
 
        $data = DB::select('select * 
        from `monkeygeniuses_journals` 
        where monkeygeniuses_journals.id != "" 
        '.$keywrod_sql.' '.$status_sql.'
        order by monkeygeniuses_journals.id DESC'); 

        return $data;
    }

    public function datatableJournal(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable($request->keywrod, $request->status);
            // ===================QUERY-DATATABLE======================= // 
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('id', function($row){    
            return $row->id;
        }) 
        ->addColumn('journal_title', function($row){    
            $img='<img src="'.asset('images/journal').'/'.$row->journal_image_thumb_desktop.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
            return '<a href="'.route('journal.edit', [$row->id]).'"> '.$img.$row->journal_title.'</a>';
        })   
        ->addColumn('journal_year', function($row){    
            return $row->journal_year;
        })  
        ->addColumn('deleted_at', function($row){  
            $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
            if($row->deleted_at==1){
                $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>'; 
            }
            return $deleted_at;
        })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('journal.edit', [$row->id]).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                return $html;
            })  
            ->rawColumns(['id','journal_title', 'journal_year', 'deleted_at', 'bntManger'])
            ->make(true);
        } 
    }

    public function closeJournal(Request $request)
    {
        if(isset($request)){
            $data=monkeygeniuses_journal::find($request->id); 
            $uploade_location = 'images/journal/';  
            $uploade_location_pdf = 'images/journal/pdf/';  
            if(!empty($data->file_pdf)){
                unlink($uploade_location_pdf.$data->file_pdf);
            }
            if(!empty($data->journal_image_desktop) && !empty($data->journal_image_thumb_desktop)){
                unlink($uploade_location.$data->journal_image_desktop);
                unlink($uploade_location.$data->journal_image_thumb_desktop);
            }

            $data=DB::table('monkeygeniuses_journals')
            ->where('monkeygeniuses_journals.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function saveJournal(Request $request)
    {   
        if(isset($request)){ 
            $validatedData = $request->validate(
                [  
                    'journal_title' => ['required', 'string', 'max:255'], 
                    'journal_date' => ['required'], 
                    
                    'journal_file_text' => ['required'], 
                    'status' => ['required'],  
 
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
                $file_text="journal-".hexdec(uniqid()).".text"; 
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully."; 
                $file_name=$request->file_upload_hdf; 
                $file_name_decktop=$request->file_upload_dektop_hdf;
                $file_name_pdf=$request->file_upload_pdf_hdf;
                $file_text=$request->journal_file_text_hdfs;
            }

            if(!empty($request->journal_file_text)){  
                Storage::disk('local')->put($file_text, $request->journal_file_text);
            } 

            if($request->file('file_upload_pdf')){
                if(!empty($request->file('file_upload_pdf'))){ 
                    $uploade_location_pdf = 'images/journal/pdf/';

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
                    $uploade_location = 'images/journal/';

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
                    $uploade_location_dektop = 'images/journal/';  

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
                'journal_title'  => $request->journal_title,    
                'journal_year'   => explode("-",$request->journal_date)[0],  
                'journal_month'  => explode("-",$request->journal_date)[1],  
                'journal_file_text' => $file_text,  
                'file_pdf' => $file_name_pdf, 

                'journal_meta_title' => $request->journal_meta_title, 
                'journal_meta_description' => $request->journal_meta_description, 
                'journal_meta_keyword' => $request->journal_meta_keyword,  
   
                'journal_image_thumb_desktop' => $file_name, 
                'journal_image_desktop' => $file_name_decktop, 
  
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),  
            );
 
            if($request->statusData=="C"){
                DB::table('monkeygeniuses_journals')->insert($data); 
                return redirect()->route('journal.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('monkeygeniuses_journals')
                ->where('monkeygeniuses_journals.id', $request->id)
                ->update($data);  
                return redirect()->route('journal.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }

    public function closeJournalPdf(Request $request)
    {
        if(isset($request)){ 
            $uploade_location_pdf = 'images/journal/pdf/';  
            $data_pdf=array("file_pdf" => NULL);
            $data=DB::table('monkeygeniuses_journals')
            ->where('monkeygeniuses_journals.id', $request->id)
            ->update($data_pdf); 
            if(!empty($request->file)){
                unlink($uploade_location_pdf.$request->file);  
            }
        }  
        return $data;
    }
}
