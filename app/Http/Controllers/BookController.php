<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use DataTables;  
use App\Models\monkeygeniuses_book;


class BookController extends Controller
{
    public function booklist()
    {     
        $data=array(); 
        return view('admin.book.book_list', compact('data'));
    }  

    public function bookadd()
    {
        $data=array(); 
        return view('admin.book.book_add', compact('data'));
    }

    public function bookedit($get_id)
    {
        $data=array( 
            "book_find" => monkeygeniuses_book::find($get_id),
        );  
        return view('admin.book.book_edit', compact('data'));
    }  


    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $book_type)
    {   
        $keywrod_sql=""; $status_sql=""; $book_type_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and monkeygeniuses_books.book_title LIKE '%".$keywrod."%'
            or monkeygeniuses_books.book_author LIKE '%".$keywrod."%'
            or monkeygeniuses_books.book_keyword LIKE '%".$keywrod."%'
            or monkeygeniuses_books.book_publishing_agency LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and monkeygeniuses_books.deleted_at = ".$status.""; 
        }

        if(isset($book_type)){  
            $book_type_sql=" and monkeygeniuses_books.book_type = ".$book_type.""; 
        }

        $data = DB::select('select * 
        from `monkeygeniuses_books` 
        where monkeygeniuses_books.id != "" 
        '.$keywrod_sql.' '.$status_sql.' '.$book_type_sql.'
        order by monkeygeniuses_books.id DESC'); 

        return $data;
    }

    public function datatableBook(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable($request->keywrod, $request->status, $request->book_type);
            // ===================QUERY-DATATABLE======================= // 
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('id', function($row){    
            return $row->id;
        }) 
        ->addColumn('book_title', function($row){    
            $img='<img src="'.asset('images/book').'/'.$row->book_image_thumb_desktop.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
            return '<a href="'.route('book.edit', [$row->id]).'"> '.$img.$row->book_title.'</a>';
        })   
        ->addColumn('book_author', function($row){    
            return $row->book_author;
        })   
        ->addColumn('book_publishing_agency', function($row){    
            return $row->book_publishing_agency;
        })   
        ->addColumn('book_type', function($row){  
            $book_type="";
            if($row->book_type==1){
                $book_type="หนังสือ";
            } else  if($row->book_type==2){
                $book_type="วารสารสำนักงาน";
            }
            return $book_type;
        })   
        ->addColumn('deleted_at', function($row){  
            $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
            if($row->deleted_at==1){
                $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>'; 
            }
            return $deleted_at;
        })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('book.edit', [$row->id]).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                return $html;
            })  
            ->rawColumns(['id','book_title', 'book_author', 'book_publishing_agency', 'book_type', 'book_year', 'deleted_at', 'bntManger'])
            ->make(true);
        } 
    }

    public function closeBook(Request $request)
    {
        if(isset($request)){
            $data=monkeygeniuses_book::find($request->id);
            $uploade_location_pdf = 'images/book/pdf/'; 
            $uploade_location = 'images/book/'; 
            if(!empty($data->book_file_pdf)){
                unlink($uploade_location_pdf.$data->book_file_pdf);
            }

            if(!empty($data->book_image_desktop) && !empty($data->book_image_thumb_desktop)){
                unlink($uploade_location.$data->book_image_desktop);
                unlink($uploade_location.$data->book_image_thumb_desktop);
            }

            $data=DB::table('monkeygeniuses_books')
            ->where('monkeygeniuses_books.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function closeBookPdf(Request $request)
    {
        if(isset($request)){ 
            $uploade_location_pdf = 'images/book/pdf/';  
            $data_pdf=array("book_file_pdf" => NULL);
            $data=DB::table('monkeygeniuses_books')
            ->where('monkeygeniuses_books.id', $request->id)
            ->update($data_pdf); 
            if(!empty($request->file)){
                unlink($uploade_location_pdf.$request->file);  
            }
        }  
        return $data;
    }

    public function saveBook(Request $request)
    {  
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'book_title' => ['required', 'string', 'max:255'],
                    'book_author' => ['required', 'string', 'max:255'],
                    'book_type' => ['required'],
                    'book_keyword' => ['required', 'string'],
                    'book_year' => ['required', 'max:255'],
                    'book_publishing_agency' =>['required', 'string', 'max:255'],
                     
                    'status' => ['required'], 

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
                    $uploade_location_pdf = 'images/book/pdf/';

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
                    $uploade_location = 'images/book/';

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
                    $uploade_location_dektop = 'images/book/';  

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
                'book_title'  => $request->book_title, 
                'book_author' => $request->book_author, 
                'book_type' => $request->book_type, 
                'book_keyword' => $request->book_keyword, 
                'book_year' => $request->book_year, 
                'book_publishing_agency' => $request->book_publishing_agency,  
                'book_meta_title' => $request->book_meta_title, 
                'book_meta_description' => $request->book_meta_description, 
                'book_meta_keyword' => $request->book_meta_keyword,
  
                'book_file_pdf' => $file_name_pdf, 
                'book_image_thumb_desktop' => $file_name, 
                'book_image_desktop' => $file_name_decktop, 
 
                'book_date' => new \DateTime(),  
                'deleted_at' => $request->status, 
                'ip_address' => $request->ip(),
                $dataType    => new \DateTime(),  
            );
 
            if($request->statusData=="C"){
                DB::table('monkeygeniuses_books')->insert($data); 
                return redirect()->route('book.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('monkeygeniuses_books')
                ->where('monkeygeniuses_books.id', $request->id)
                ->update($data);  
                return redirect()->route('book.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }
}
