<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use DataTables;  
use App\Models\monkeygeniuses_news;
use Illuminate\Support\Facades\Storage;

class NewsCortroller extends Controller
{
    public function newslist()
    {     
        $data=array(); 
        return view('admin.news.news_list', compact('data'));
    }  

    public function newsadd()
    {
        $data=array(); 
        return view('admin.news.news_add', compact('data'));
    }

    public function newsedit($get_id)
    {
        $data=array( 
            "news_find" => monkeygeniuses_news::find($get_id),
        );  
        return view('admin.news.news_edit', compact('data'));
    }  


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $date)
    {   
        $keywrod_sql=""; $status_sql=""; $date_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and monkeygeniuses_news.news_title LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and monkeygeniuses_news.deleted_at = ".$status.""; 
        }

        if(isset($date)){ 
            $date_sql=" and (monkeygeniuses_news.created_at BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59')";  
        } 
        
        $data = DB::select('select * 
        from `monkeygeniuses_news` 
        where monkeygeniuses_news.id != "" 
        '.$keywrod_sql.' '.$status_sql.' '.$date_sql.'
        order by monkeygeniuses_news.id DESC'); 

        return $data;
    }

    public function datatableNews(Request $request)
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
        ->addColumn('news_title', function($row){    
            $img='<img src="'.asset('images/news').'/'.$row->news_image_thumb_desktop.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
            return '<a href="'.route('news.edit', [$row->id]).'"> '.$img.$row->news_title.'</a>';
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
                $html='<a href="'.route('news.edit', [$row->id]).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                return $html;
            })  
            ->rawColumns(['id','news_title', 'created_at', 'deleted_at', 'bntManger'])
            ->make(true);
        } 
    }

    public function closeNews(Request $request)
    {
        if(isset($request)){ 
            $data=monkeygeniuses_news::find($request->id);  
            $uploade_location = 'images/news/';  
            $uploade_location_pdf = 'images/news/pdf/';  
            if(!empty($data->file_pdf)){
                unlink($uploade_location_pdf.$data->file_pdf);
            }
            if(!empty($data->news_image_desktop) && !empty($data->news_image_thumb_desktop)){
                unlink($uploade_location.$data->news_image_desktop);
                unlink($uploade_location.$data->news_image_thumb_desktop);
            }

            if(!empty($data->news_file_text)){
                unlink(storage_path().'/app/'.$data->news_file_text); 
            }

            $data=DB::table('monkeygeniuses_news')
            ->where('monkeygeniuses_news.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function saveNews(Request $request)
    {     
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'news_title' => ['required', 'string', 'max:255'], 
                    'news_intro' => ['required', 'string', 'max:255'],    
                    'news_file_text' => ['required'],  
 
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
                $file_text="news-".hexdec(uniqid()).".text";  
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully."; 
                $file_name=$request->file_upload_hdf; 
                $file_name_decktop=$request->file_upload_dektop_hdf;
                $file_name_pdf=$request->file_upload_pdf_hdf;
                $file_text=$request->news_file_text_hdfs;
            }

            if(!empty($request->news_file_text)){  
                Storage::disk('local')->put($file_text, $request->news_file_text);
            } 


            if($request->file('file_upload_pdf')){
                if(!empty($request->file('file_upload_pdf'))){ 
                    $uploade_location_pdf = 'images/news/pdf/';

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
                    $uploade_location = 'images/news/';

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
                    $uploade_location_dektop = 'images/news/';  

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
                'news_title'  => $request->news_title,    
                'news_intro'  => $request->news_intro,  
                'news_file_text' => $file_text,  
                
                'news_meta_title'       => $request->news_meta_title, 
                'news_meta_description' => $request->news_meta_description, 
                'news_meta_keyword'     => $request->news_meta_keyword,  
   
                'news_image_thumb_desktop' => $file_name, 
                'news_image_desktop' => $file_name_decktop, 
                'file_pdf' => $file_name_pdf, 
                
                'news_date'  => new \DateTime(),  
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),  
            );
 
            if($request->statusData=="C"){
                DB::table('monkeygeniuses_news')->insert($data); 
                return redirect()->route('news.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('monkeygeniuses_news')
                ->where('monkeygeniuses_news.id', $request->id)
                ->update($data);  
                return redirect()->route('news.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }

    public function closeNewsPdf(Request $request)
    {
        if(isset($request)){ 
            $uploade_location_pdf = 'images/news/pdf/';  
            $data_pdf=array("file_pdf" => NULL);
            $data=DB::table('monkeygeniuses_news')
            ->where('monkeygeniuses_news.id', $request->id)
            ->update($data_pdf); 
            if(!empty($request->file)){
                unlink($uploade_location_pdf.$request->file);  
            }
        }  
        return $data;
    }
}
