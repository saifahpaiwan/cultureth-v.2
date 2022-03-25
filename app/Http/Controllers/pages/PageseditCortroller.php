<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;

use App\Models\about_history;
use App\Models\about_vision; 
use App\Models\about_symbol; 
use App\Models\about_policy;
use App\Models\about_network; 
use App\Models\about_report; 
use App\Models\admin_structure; 
use App\Models\admin_commitee;  
use App\Models\admin_executive;  
use App\Models\admin_personel;  
use App\Models\contact;  
use App\Models\preserve_history;  
use App\Models\preserve_duties;  
use App\Models\preserve_committee;  

class PageseditCortroller extends Controller
{ 
    public function pagesedit($get_id)
    {      
        if(isset($get_id)){
            if($get_id==1){
                $data=array( 
                    "Query_find" => about_history::find(1),
                    "db"         => "about_histories",
                    "title"      => "ประวัติความเป็นมา",
                    "get_id"     => $get_id
                );  
            } else if($get_id==2){
                $data=array( 
                    "Query_find" => about_vision::find(1),
                    "db"         => "about_visions",
                    "title"      => "ปรัชญา วิสัยทัศน์ พันธกิจ",
                    "get_id"     => $get_id
                );  
            } else if($get_id==3){
                $data=array( 
                    "Query_find" => about_symbol::find(1),
                    "db"         => "about_symbols",
                    "title"      => "ตราสัญลักษณ์",
                    "get_id"     => $get_id
                );  
            } else if($get_id==4){
                $data=array( 
                    "Query_find" => about_policy::find(1),
                    "db"         => "about_policies",
                    "title"      => "นโยบายและแผนยุทธศาสตร์",
                    "get_id"     => $get_id
                );  
            } else if($get_id==5){
                $data=array( 
                    "Query_find" => about_network::find(1),
                    "db"         => "about_networks",
                    "title"      => "เครือข่ายความร่วมมือ",
                    "get_id"     => $get_id
                );  
            } else if($get_id==6){
                $data=array( 
                    "Query_find" => about_report::find(1),
                    "db"         => "about_reports",
                    "title"      => "รายงานประจำปี",
                    "get_id"     => $get_id
                );  
            } else if($get_id==7){
                $data=array( 
                    "Query_find" => admin_structure::find(1),
                    "db"         => "admin_structures",
                    "title"      => "โครงสร้างองค์กร",
                    "get_id"     => $get_id
                );  
            } else if($get_id==8){
                $data=array( 
                    "Query_find" => admin_commitee::find(1),
                    "db"         => "admin_commitees",
                    "title"      => "คณะกรรมการประจำสำนัก",
                    "get_id"     => $get_id
                );  
            } else if($get_id==9){
                $data=array( 
                    "Query_find" => admin_executive::find(1),
                    "db"         => "admin_executives",
                    "title"      => "ทำเนียบผู้บริหาร",
                    "get_id"     => $get_id
                );  
            } else if($get_id==10){
                $data=array( 
                    "Query_find" => admin_personel::find(1),
                    "db"         => "admin_personels",
                    "title"      => "บุคลากร",
                    "get_id"     => $get_id
                );  
            } else if($get_id==11){
                $data=array( 
                    "Query_find" => preserve_history::find(1),
                    "db"         => "preserve_histories",
                    "title"      => "ความเป็นมา",
                    "get_id"     => $get_id
                );  
            } else if($get_id==12){
                $data=array( 
                    "Query_find" => preserve_duties::find(1),
                    "db"         => "preserve_duties",
                    "title"      => "บทบาทหน้าที่",
                    "get_id"     => $get_id
                ); 
            } else if($get_id==13){
                $data=array( 
                    "Query_find" => preserve_committee::find(1),
                    "db"         => "preserve_committees",
                    "title"      => "คณะกรรมการ",
                    "get_id"     => $get_id
                );  
            } else if($get_id==14){
                $data=array( 
                    "Query_find" => contact::find(1),
                    "db"         => "contacts",
                    "title"      => "ติดต่อเรา",
                    "get_id"     => $get_id
                );  
            }
        } 
        return view('admin.pagesedit.pages_edit', compact('data'));
    }  

    public function savePages(Request $request)
    { 
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'title' => ['required', 'string', 'max:255'],    
                    'status' => ['required'],
                    'file_text' => ['required'],
                    'file_upload_pdf' => ['mimes:pdf', 'max:50000'],   
                ] 
            );  

            if(isset($request->statusData)){
                if($request->statusData=="C"){
                    $dataType="created_at";
                    $msg="Save data successfully."; 
                    $file_text=NULL;
                    $file_name=NULL;  
                    $file_name_pdf=NULL;
                } else if($request->statusData=="U"){
                    $dataType="updated_at";
                    $msg="Update data successfully."; 
                    $file_text=$request->file_text_hdfs;
                    $file_name=$request->file_upload_hdf; 
                    $file_name_pdf=$request->file_upload_pdf_hdf;
                }
            }
   
            if(!empty($file_text)){  
                Storage::disk('local')->put($file_text, $request->file_text);
            } else {
                $file_text=$request->db.".text"; ;
                Storage::disk('local')->put($file_text, $request->file_text);
            }   

            if($request->file('file_upload_pdf')){
                if(!empty($request->file('file_upload_pdf'))){ 
                    $uploade_location_pdf = 'images/page_edit/pdf/';

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
                    $uploade_location = 'images/page_edit/'; 
                    if($file_name!=""){ 
                        unlink($uploade_location.$file_name);
                    } 
                    $file = $request->file('file_upload');
                    $file_gen = hexdec(uniqid());
                    $file_ext = strtolower($file->getClientOriginalExtension()); 
                    $file_name = $file_gen.'.'.$file_ext;
                    $file->move($uploade_location, $file_name); 
                } 
            }
            
            $data=array(
                'title'     => $request->title, 
                'sub_title' => $request->sub_title,   
                'file_text' => $file_text,  
                'image_thumb_desktop' => $file_name,  
                'file_pdf' => $file_name_pdf, 
                
                'meta_title'       => $request->meta_title, 
                'meta_description' => $request->meta_description, 
                'meta_keyword'     => $request->meta_keyword,  
    
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType => new \DateTime(),  
            );

            if(isset($request->db)){
                if($request->statusData=="C"){
                    DB::table($request->db)->insert($data); 
                } else if($request->statusData=="U"){
                    DB::table($request->db)
                    ->where($request->db.'.id', 1)
                    ->update($data);  
                } 
            } 
            return redirect()->route('pagesedit', [$request->get_id])->with('success', $msg); 
        }
    }

    public function closePagesPdf(Request $request)
    {
        if(isset($request)){ 
            $uploade_location_pdf = 'images/page_edit/pdf/';  
            $data_pdf=array("file_pdf" => NULL);
            $data=DB::table($request->db)
            ->where($request->db.'.id', 1)
            ->update($data_pdf); 
            if(!empty($request->file)){
                unlink($uploade_location_pdf.$request->file);  
            }
        }  
        return $data;
    }
}
