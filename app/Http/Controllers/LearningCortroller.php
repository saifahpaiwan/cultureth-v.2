<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use DataTables;  
use App\Models\monkeygeniuses_learning_resources;
use App\Models\learning_category;
use Illuminate\Support\Facades\Storage;

class LearningCortroller extends Controller
{
    public function learninglist()
    {     
        $data=array(
            "Query_learning_category" => learning_category::where('deleted_at', 0)->get(),
        ); 
        return view('admin.learning.learning_list', compact('data'));
    }  

    public function learningadd()
    {
        $data=array(
            "Query_learning_category" => learning_category::where('deleted_at', 0)->get(),
        ); 
        return view('admin.learning.learning_add', compact('data'));
    }

    public function learningedit($get_id)
    {
        $data=array( 
            "Query_learning_category" => learning_category::where('deleted_at', 0)->get(),
            "learning_find" => monkeygeniuses_learning_resources::find($get_id),
        );  
        return view('admin.learning.learning_edit', compact('data'));
    }  

    public function learningcategorylist()
    {
        $data=array(); 
        return view('admin.learning.category_list', compact('data'));
    }

    public function learningcategoryadd()
    {
        $data=array(); 
        return view('admin.learning.category_add', compact('data'));
    }

    public function learningcategoryedit($get_id)
    {
        $data=array( 
            "learningcategory_find" => learning_category::find($get_id),
        );  
        return view('admin.learning.category_edit', compact('data'));
    } 

    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $learning_category)
    {   
        $keywrod_sql=""; $status_sql=""; $learning_category_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and monkeygeniuses_learning_resources.learning_title LIKE '%".$keywrod."%'
            or monkeygeniuses_learning_resources.learning_location LIKE '%".$keywrod."%' 
            or monkeygeniuses_learning_resources.learning_publishing_agency LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and monkeygeniuses_learning_resources.deleted_at = ".$status.""; 
        }

        if(isset($learning_category)){  
            $learning_category_sql=" and monkeygeniuses_learning_resources.learning_category = ".$learning_category.""; 
        }

        $data = DB::select('select monkeygeniuses_learning_resources.id as id, monkeygeniuses_learning_resources.learning_title as learning_title,
        monkeygeniuses_learning_resources.learning_year as learning_year, monkeygeniuses_learning_resources.learning_publishing_agency as learning_publishing_agency,
        monkeygeniuses_learning_resources.learning_image_thumb_desktop as learning_image_thumb_desktop, monkeygeniuses_learning_resources.deleted_at as deleted_at,
        learning_categories.name as learning_categories_name

        from `monkeygeniuses_learning_resources` 
        LEFT JOIN learning_categories ON monkeygeniuses_learning_resources.learning_category = learning_categories.id
        where monkeygeniuses_learning_resources.id != "" 
        '.$keywrod_sql.' '.$status_sql.' '.$learning_category_sql.'
        order by monkeygeniuses_learning_resources.id DESC'); 

        return $data;
    }

    public function datatableLearning(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable($request->keywrod, $request->status, $request->learning_category);
            // ===================QUERY-DATATABLE======================= // 
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('id', function($row){    
            return $row->id;
        }) 
        ->addColumn('learning_title', function($row){    
            $img='<img src="'.asset('images/learning').'/'.$row->learning_image_thumb_desktop.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
            return '<a href="'.route('learning.edit', [$row->id]).'"> '.$img.$row->learning_title.'</a>';
        })   
        ->addColumn('learning_year', function($row){    
            return $row->learning_year;
        })   
        ->addColumn('learning_publishing_agency', function($row){    
            return $row->learning_publishing_agency;
        })   
        ->addColumn('learning_category', function($row){   
            return $row->learning_categories_name;
        })   
        ->addColumn('deleted_at', function($row){  
            $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
            if($row->deleted_at==1){
                $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>'; 
            }
            return $deleted_at;
        })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('learning.edit', [$row->id]).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                return $html;
            })  
            ->rawColumns(['id','learning_title', 'learning_year', 'learning_publishing_agency', 'learning_category', 'learning_year', 'deleted_at', 'bntManger'])
            ->make(true);
        } 
    }

    public function closeLearning(Request $request)
    {
        if(isset($request)){
            $data=monkeygeniuses_learning_resources::find($request->id);
            $uploade_location_pdf = 'images/learning/pdf/'; 
            $uploade_location = 'images/learning/'; 
            if(!empty($data->learning_file_pdf)){
                unlink($uploade_location_pdf.$data->learning_file_pdf);
            }

            if(!empty($data->learning_image_desktop) && !empty($data->learning_image_thumb_desktop)){
                unlink($uploade_location.$data->learning_image_desktop);
                unlink($uploade_location.$data->learning_image_thumb_desktop);
            }

            $data=DB::table('monkeygeniuses_learning_resources')
            ->where('monkeygeniuses_learning_resources.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function closeLearningPdf(Request $request)
    {
        if(isset($request)){ 
            $uploade_location_pdf = 'images/learning/pdf/';  
            $data_pdf=array("learning_file_pdf" => NULL);
            $data=DB::table('monkeygeniuses_learning_resources')
            ->where('monkeygeniuses_learning_resources.id', $request->id)
            ->update($data_pdf); 
            if(!empty($request->file)){
                unlink($uploade_location_pdf.$request->file);  
            }
        }  
        return $data;
    }

    public function saveLearning(Request $request)
    {  
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'learning_title' => ['required', 'string', 'max:255'],
                    'learning_location' => ['required', 'string', 'max:255'],
                    'learning_category' => ['required'], 
                    'learning_year' => ['required', 'max:255'],
                    'learning_publishing_agency' =>['required', 'string', 'max:255'], 
                    
                    'status' => ['required'],  

                    'file_text' => ['required'], 
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
                $file_text="learning-".hexdec(uniqid()).".text";  
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully.";
                $file_name_pdf=$request->file_upload_pdf_hdf;
                $file_name=$request->file_upload_hdf; 
                $file_name_decktop=$request->file_upload_dektop_hdf;
                $file_text=$request->file_text_hdfs;
            }

            if(!empty($request->file_text)){  
                Storage::disk('local')->put($file_text, $request->file_text);
            } 

            if($request->file('file_upload_pdf')){
                if(!empty($request->file('file_upload_pdf'))){ 
                    $uploade_location_pdf = 'images/learning/pdf/';

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
                    $uploade_location = 'images/learning/';

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
                    $uploade_location_dektop = 'images/learning/';  

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
                'learning_title'  => $request->learning_title, 
                'learning_location' => $request->learning_location, 
                'learning_category' => $request->learning_category,  
                'learning_year' => $request->learning_year, 
                'learning_publishing_agency' => $request->learning_publishing_agency,  

                'learning_meta_title' => $request->learning_meta_title, 
                'learning_meta_description' => $request->learning_meta_description, 
                'learning_meta_keyword' => $request->learning_meta_keyword,  
  
                'file_text' => $file_text, 
                'learning_file_pdf' => $file_name_pdf, 
                'link_vdo'          => $request->link_vdo,
                'learning_image_thumb_desktop' => $file_name, 
                'learning_image_desktop' => $file_name_decktop, 
 
                'learning_date' => new \DateTime(),  
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),  
            );
 
            if($request->statusData=="C"){
                DB::table('monkeygeniuses_learning_resources')->insert($data); 
                return redirect()->route('learning.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('monkeygeniuses_learning_resources')
                ->where('monkeygeniuses_learning_resources.id', $request->id)
                ->update($data);  
                return redirect()->route('learning.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }

    public function Query_Datatable_Learningcategory($keywrod, $status)
    {   
        $keywrod_sql=""; $status_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and learning_categories.name LIKE '%".$keywrod."%'
            or learning_categories.detail LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and learning_categories.deleted_at = ".$status.""; 
        }

        $data = DB::select('select * 
        from `learning_categories` 
        where learning_categories.id != "" 
        '.$keywrod_sql.' '.$status_sql.'
        order by learning_categories.id asc'); 

        return $data;
    }

    public function datatableLearningcategory(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable_Learningcategory($request->keywrod, $request->status);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function($row){    
                return $row->id;
            }) 
            ->addColumn('name', function($row){    
                return '<a href="'.route('learningcategory.edit', $row->id).'">'.$row->name.'</a>';
            })   
            ->addColumn('deleted_at', function($row){  
                $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
                if($row->deleted_at==1){
                    $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>';
                }  
                return $deleted_at;
            })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('learningcategory.edit', $row->id).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                return $html;
            })  
            ->rawColumns(['id','name','deleted_at','bntManger'])
            ->make(true);
        } 
    }

    public function closeLearningcategory(Request $request)
    {
        if(isset($request)){
            $data=DB::table('learning_categories')
            ->where('learning_categories.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function saveLearningcategory(Request $request)
    {
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'name' => ['required', 'string', 'max:255'],
                    'detail' => ['required', 'string'],
                    
                    'status' => ['required'], 
                ] 
            );  

            if($request->statusData=="C"){
                $dataType="created_at";
                $msg="Save data successfully.";
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully.";
            }

            $data=array(
                'name'  => $request->name, 
                'detail'  => $request->detail, 
                 
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(), 
            );

            if($request->statusData=="C"){
                DB::table('learning_categories')->insert($data); 
                return redirect()->route('learningcategory.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('learning_categories')
                ->where('learning_categories.id', $request->id)
                ->update($data);  
                return redirect()->route('learningcategory.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }
}
