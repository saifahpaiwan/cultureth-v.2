<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   
use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();

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
use App\Models\preserve_history;
use App\Models\preserve_duties;
use App\Models\preserve_committee;
use App\Models\contact;

use App\Models\monkeygeniuses_news;
use App\Models\monkeygeniuses_activity;
use App\Models\monkeygeniuses_activity_conservation;
use App\Models\monkeygeniuses_book;
use App\Models\monkeygeniuses_research; 
use App\Models\monkeygeniuses_journal; 
use App\Models\slideshow; 

use App\Models\activity_gallery; 
use App\Models\acticonservation_gallery; 
use App\Models\report_annual; 
use App\Models\cooperation_network; 

class HomeController extends Controller
{
    public function index()
    {      
        $data=array(
            "Query_news" => monkeygeniuses_news::where('deleted_at', 0)->orderBy('id', 'desc')->limit(3)->get(),
            "Query_activity" => monkeygeniuses_activity::where('deleted_at', 0)->orderBy('id', 'desc')->limit(5)->get(),
            "Query_conservation" => monkeygeniuses_activity_conservation::where('deleted_at', 0)->orderBy('id', 'desc')->limit(5)->get(),
            "Query_book" => monkeygeniuses_book::where('deleted_at', 0)->orderBy('id', 'desc')->limit(3)->get(),
            "Query_research" => monkeygeniuses_research::where('deleted_at', 0)->orderBy('id', 'desc')->limit(3)->get(),
            "Query_slideshow" => slideshow::where('deleted_at', 0)->orderBy('id', 'desc')->get(), 
        ); 
        return view('index', compact('data'));
    }  

    public function aboutHistory()
    {     
        $data=array(
            "retule" => about_history::find(1)
        ); 
        return view('about_history', compact('data'));
    }  

    public function aboutVision()
    {     
        $data=array(
            "retule" => about_vision::find(1)
        ); 
        return view('about_vision', compact('data'));
    }  

    public function aboutSymbol()
    {     
        $data=array(
            "retule" => about_symbol::find(1)
        ); 
        return view('about_symbol', compact('data'));
    }  

    public function aboutPolicy()
    {     
        $data=array(
            "retule" => about_policy::find(1)
        ); 
        return view('about_policy', compact('data'));
    }   
    
    public function aboutNetwork()
    {     
        $data=array(
            "retule" => about_network::find(1)
        ); 
        return view('about_network', compact('data'));
    } 

    public function aboutReport()
    {     
        $data=array(
            "retule" => about_report::find(1)
        ); 
        return view('about_report', compact('data'));
    } 

    public function adminStructure() 
    {     
        $data=array(
            "retule" => admin_structure::find(1)
        ); 
        return view('admin_structure', compact('data'));
    } 

    public function adminCommitee()
    {     
        $data=array(
            "retule" => admin_commitee::find(1)
        ); 
        return view('admin_commitee', compact('data'));
    } 

    public function adminExecutive()
    {     
        $data=array(
            "retule" => admin_executive::find(1)
        ); 
        return view('admin_executive', compact('data'));
    } 

    public function adminPersonel()
    {     
        $data=array(
            "retule" => admin_personel::find(1)
        ); 
        return view('admin_personel', compact('data'));
    } 
 
    public function preserveHistory()
    {     
        $data=array(
            "retule" => preserve_history::find(1)
        ); 
        return view('preserve_history', compact('data'));
    } 
    
    public function preserveDuties()
    {     
        $data=array(
            "retule" => preserve_duties::find(1)
        ); 
        return view('preserve_duties', compact('data'));
    } 

    public function preserveCommittee()
    {     
        $data=array(
            "retule" => preserve_committee::find(1)
        ); 
        return view('preserve_committee', compact('data'));
    } 

    public function contact()
    {     
        $data=array(
            "retule" => contact::find(1)
        ); 
        return view('contact', compact('data'));
    } 

    // ============================ BOOK ============================ //
    public function book()
    {     
        if(isset($_GET['keyword']) || isset($_GET['year'])){ 
            if(!empty($_GET['keyword']) && empty($_GET['year'])){
                $querybook=monkeygeniuses_book::where('deleted_at', 0)
                ->where('book_title', 'like', '%'.$_GET["keyword"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(empty($_GET['keyword']) && !empty($_GET['year'])){
                $querybook=monkeygeniuses_book::where('deleted_at', 0)
                ->where('book_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(!empty($_GET['keyword']) && !empty($_GET['year'])){
                $querybook=monkeygeniuses_book::where('deleted_at', 0)
                ->where('book_title', 'like', '%'.$_GET["keyword"].'%')
                ->where('book_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else {
                $querybook=monkeygeniuses_book::where('deleted_at', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
            }
        } else {
            $querybook=monkeygeniuses_book::where('deleted_at', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);
        } 
 
        $data=array(
            "Query_book" => $querybook,
        );  
        return view('book', compact('data'));
    }  

    public function bookView($get_id)
    {
        $data=array(
            "get_id" => $get_id,
            "result" => monkeygeniuses_book::where('deleted_at', 0)->where('id', $get_id)->first(),
        );  
        return view('book_view', compact('data'));
    }

    // ============================ research ============================ //
    public function research()
    {     
        if(isset($_GET['keyword']) || isset($_GET['year'])){ 
            if(!empty($_GET['keyword']) && empty($_GET['year'])){
                $queryresearch=monkeygeniuses_research::where('deleted_at', 0)
                ->where('research_title', 'like', '%'.$_GET["keyword"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(empty($_GET['keyword']) && !empty($_GET['year'])){
                $queryresearch=monkeygeniuses_research::where('deleted_at', 0)
                ->where('research_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(!empty($_GET['keyword']) && !empty($_GET['year'])){
                $queryresearch=monkeygeniuses_research::where('deleted_at', 0)
                ->where('research_title', 'like', '%'.$_GET["keyword"].'%')
                ->where('research_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else {
                $queryresearch=monkeygeniuses_research::where('deleted_at', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
            }
        } else {
            $queryresearch=monkeygeniuses_research::where('deleted_at', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);
        } 
 
        $data=array(
            "Query_research" => $queryresearch,
        );  
        return view('research', compact('data'));
    }  

    public function researchView($get_id)
    {
        $data=array(
            "get_id" => $get_id,
            "result" => monkeygeniuses_research::where('deleted_at', 0)->where('id', $get_id)->first(),
        );  
        return view('research_view', compact('data'));
    }

    // ============================ learning ============================ //
    public function learning()
    {     
        if(isset($_GET['keyword']) || isset($_GET['year'])){ 
            if(!empty($_GET['keyword']) && empty($_GET['year'])){
                $querylearning=DB::table('monkeygeniuses_learning_resources')
                ->select('*', 'monkeygeniuses_learning_resources.id as id', 'learning_categories.name as categories_name')   
                ->leftJoin('learning_categories', 'monkeygeniuses_learning_resources.learning_category', '=', 'learning_categories.id')   
                ->where('monkeygeniuses_learning_resources.deleted_at', 0)
                ->where('monkeygeniuses_learning_resources.learning_title', 'like', '%'.$_GET["keyword"].'%')
                ->orderBy('monkeygeniuses_learning_resources.id', 'desc')
                ->paginate(10);
            } else if(empty($_GET['keyword']) && !empty($_GET['year'])){
                $querylearning=DB::table('monkeygeniuses_learning_resources')
                ->select('*', 'monkeygeniuses_learning_resources.id as id', 'learning_categories.name as categories_name')   
                ->leftJoin('learning_categories', 'monkeygeniuses_learning_resources.learning_category', '=', 'learning_categories.id')   
                ->where('monkeygeniuses_learning_resources.deleted_at', 0)
                ->where('monkeygeniuses_learning_resources.learning_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('monkeygeniuses_learning_resources.id', 'desc')
                ->paginate(10);
            } else if(!empty($_GET['keyword']) && !empty($_GET['year'])){
                $querylearning=DB::table('monkeygeniuses_learning_resources')
                ->select('*', 'monkeygeniuses_learning_resources.id as id', 'learning_categories.name as categories_name')   
                ->leftJoin('learning_categories', 'monkeygeniuses_learning_resources.learning_category', '=', 'learning_categories.id')   
                ->where('monkeygeniuses_learning_resources.deleted_at', 0)
                ->where('monkeygeniuses_learning_resources.learning_title', 'like', '%'.$_GET["keyword"].'%')
                ->where('monkeygeniuses_learning_resources.learning_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('monkeygeniuses_learning_resourcesid', 'desc')
                ->paginate(10);
            } else {
                $querylearning=DB::table('monkeygeniuses_learning_resources')
                ->select('*', 'monkeygeniuses_learning_resources.id as id', 'learning_categories.name as categories_name')   
                ->leftJoin('learning_categories', 'monkeygeniuses_learning_resources.learning_category', '=', 'learning_categories.id')   
                ->where('monkeygeniuses_learning_resources.deleted_at', 0)
                ->orderBy('monkeygeniuses_learning_resources.id', 'desc')
                ->paginate(10);
            }
        } else {
            $querylearning=DB::table('monkeygeniuses_learning_resources')
            ->select('*', 'monkeygeniuses_learning_resources.id as id', 'learning_categories.name as categories_name')   
            ->leftJoin('learning_categories', 'monkeygeniuses_learning_resources.learning_category', '=', 'learning_categories.id')   
            ->where('monkeygeniuses_learning_resources.deleted_at', 0)
            ->orderBy('monkeygeniuses_learning_resources.id', 'desc')
            ->paginate(10);
        } 
 
        $data=array(
            "Query_learning" => $querylearning,
        );  
        return view('learning', compact('data'));
    }  

    public function learningView($get_id)
    {
        $data=array(
            "get_id" => $get_id,
            "result" => DB::table('monkeygeniuses_learning_resources')
            ->select('*', 'monkeygeniuses_learning_resources.id as id', 'learning_categories.name as categories_name')   
            ->leftJoin('learning_categories', 'monkeygeniuses_learning_resources.learning_category', '=', 'learning_categories.id')
            ->where('monkeygeniuses_learning_resources.id', $get_id)->first(),
        );  
        return view('learning_view', compact('data'));
    }

    // ============================ news ============================ //
    public function news()
    {     
        if(isset($_GET['keyword']) || isset($_GET['year'])){ 
            if(!empty($_GET['keyword']) && empty($_GET['year'])){
                $querynews=monkeygeniuses_news::where('deleted_at', 0)
                ->where('news_title', 'like', '%'.$_GET["keyword"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(empty($_GET['keyword']) && !empty($_GET['year'])){
                $querynews=monkeygeniuses_news::where('deleted_at', 0)
                ->where('news_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(!empty($_GET['keyword']) && !empty($_GET['year'])){
                $querynews=monkeygeniuses_news::where('deleted_at', 0)
                ->where('news_title', 'like', '%'.$_GET["keyword"].'%')
                ->where('news_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else {
                $querynews=monkeygeniuses_news::where('deleted_at', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
            }
        } else {
            $querynews=monkeygeniuses_news::where('deleted_at', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);
        } 
 
        $data=array(
            "Query_news" => $querynews,
        );  
        return view('news', compact('data'));
    }  

    public function newsView($get_id)
    {
        $data=array(
            "get_id" => $get_id,
            "result" => monkeygeniuses_news::where('deleted_at', 0)->where('id', $get_id)->first(),
        );  
        return view('news_view', compact('data'));
    }

    // ============================ acticonservation ============================ //
    public function acticonservation()
    {     
        if(isset($_GET['keyword']) || isset($_GET['year'])){ 
            if(!empty($_GET['keyword']) && empty($_GET['year'])){
                $queryacticonservation=monkeygeniuses_activity_conservation::where('deleted_at', 0)
                ->where('acticonservation_title', 'like', '%'.$_GET["keyword"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(empty($_GET['keyword']) && !empty($_GET['year'])){
                $queryacticonservation=monkeygeniuses_activity_conservation::where('deleted_at', 0)
                ->where('acticonservation_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(!empty($_GET['keyword']) && !empty($_GET['year'])){
                $queryacticonservation=monkeygeniuses_activity_conservation::where('deleted_at', 0)
                ->where('acticonservation_title', 'like', '%'.$_GET["keyword"].'%')
                ->where('acticonservation_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else {
                $queryacticonservation=monkeygeniuses_activity_conservation::where('deleted_at', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
            }
        } else {
            $queryacticonservation=monkeygeniuses_activity_conservation::where('deleted_at', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);
        } 
 
        $data=array(
            "Query_acticonservation" => $queryacticonservation,
        );  
        return view('acticonservation', compact('data'));
    }  

    public function acticonservationView($get_id)
    {
        $data=array(
            "get_id" => $get_id,
            "acticonservation_gallery" => acticonservation_gallery::where('deleted_at', 0)->where('acticonservation_id', $get_id)->get(),
            "result" => monkeygeniuses_activity_conservation::where('deleted_at', 0)->where('id', $get_id)->first(),
        );  
        return view('acticonservation_view', compact('data'));
    }

    // ============================ journal ============================ //
    public function journal()
    {     
        if(isset($_GET['keyword']) || isset($_GET['year'])){ 
            if(!empty($_GET['keyword']) && empty($_GET['year'])){
                $queryjournal=monkeygeniuses_journal::where('deleted_at', 0)
                ->where('journal_title', 'like', '%'.$_GET["keyword"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(empty($_GET['keyword']) && !empty($_GET['year'])){
                $queryjournal=monkeygeniuses_journal::where('deleted_at', 0)
                ->where('journal_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(!empty($_GET['keyword']) && !empty($_GET['year'])){
                $queryjournal=monkeygeniuses_journal::where('deleted_at', 0)
                ->where('journal_title', 'like', '%'.$_GET["keyword"].'%')
                ->where('journal_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else {
                $queryjournal=monkeygeniuses_journal::where('deleted_at', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
            }
        } else {
            $queryjournal=monkeygeniuses_journal::where('deleted_at', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);
        } 
 
        $data=array(
            "Query_journal" => $queryjournal,
        );  
        return view('journal', compact('data'));
    }  

    public function journalView($get_id)
    {
        $data=array(
            "get_id" => $get_id,
            "result" => monkeygeniuses_journal::where('deleted_at', 0)->where('id', $get_id)->first(),
        );  
        return view('journal_view', compact('data'));
    }

    // ============================ activity ============================ //
    public function activity()
    {     
        if(isset($_GET['keyword']) || isset($_GET['year'])){ 
            if(!empty($_GET['keyword']) && empty($_GET['year'])){
                $queryactivity=monkeygeniuses_activity::where('deleted_at', 0)
                ->where('activity_title', 'like', '%'.$_GET["keyword"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(empty($_GET['keyword']) && !empty($_GET['year'])){
                $queryactivity=monkeygeniuses_activity::where('deleted_at', 0)
                ->where('activity_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(!empty($_GET['keyword']) && !empty($_GET['year'])){
                $queryactivity=monkeygeniuses_activity::where('deleted_at', 0)
                ->where('activity_title', 'like', '%'.$_GET["keyword"].'%')
                ->where('activity_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else {
                $queryactivity=monkeygeniuses_activity::where('deleted_at', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
            }
        } else {
            $queryactivity=monkeygeniuses_activity::where('deleted_at', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);
        } 
 
        $data=array(
            "Query_activity" => $queryactivity,
        );  
        return view('activity', compact('data'));
    }  

    public function activityView($get_id)
    {
        $data=array(
            "get_id" => $get_id,
            "activity_gallery" => activity_gallery::where('deleted_at', 0)->where('activity_id', $get_id)->get(),
            "result" => monkeygeniuses_activity::where('deleted_at', 0)->where('id', $get_id)->first(),
        );  
        return view('activity_view', compact('data'));
    } 

    // ============================ Report Annual ============================ //
    public function reportannual()
    {     
        if(isset($_GET['keyword']) || isset($_GET['year'])){ 
            if(!empty($_GET['keyword']) && empty($_GET['year'])){
                $queryannual=report_annual::where('deleted_at', 0)
                ->where('annual_title', 'like', '%'.$_GET["keyword"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(empty($_GET['keyword']) && !empty($_GET['year'])){
                $queryannual=report_annual::where('deleted_at', 0)
                ->where('annual_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(!empty($_GET['keyword']) && !empty($_GET['year'])){
                $queryannual=report_annual::where('deleted_at', 0)
                ->where('annual_title', 'like', '%'.$_GET["keyword"].'%')
                ->where('annual_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else {
                $queryannual=report_annual::where('deleted_at', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
            }
        } else {
            $queryannual=report_annual::where('deleted_at', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);
        } 
 
        $data=array(
            "Query_annual" => $queryannual,
        );  
        return view('reportannual', compact('data'));
    }  

    public function reportannualView($get_id)
    {
        $data=array(
            "get_id" => $get_id,
            "result" => report_annual::where('deleted_at', 0)->where('id', $get_id)->first(),
        );  
        return view('reportannual_view', compact('data'));
    }

    // ============================ Cooperation Network ============================ //
    public function cooperationnetwork()
    {     
        if(isset($_GET['keyword']) || isset($_GET['year'])){ 
            if(!empty($_GET['keyword']) && empty($_GET['year'])){
                $querynetwork=cooperation_network::where('deleted_at', 0)
                ->where('network_title', 'like', '%'.$_GET["keyword"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(empty($_GET['keyword']) && !empty($_GET['year'])){
                $querynetwork=cooperation_network::where('deleted_at', 0)
                ->where('network_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else if(!empty($_GET['keyword']) && !empty($_GET['year'])){
                $querynetwork=cooperation_network::where('deleted_at', 0)
                ->where('network_title', 'like', '%'.$_GET["keyword"].'%')
                ->where('network_year', 'like', '%'.$_GET["year"].'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
            } else {
                $querynetwork=cooperation_network::where('deleted_at', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
            }
        } else {
            $querynetwork=cooperation_network::where('deleted_at', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);
        } 
 
        $data=array(
            "Query_network" => $querynetwork,
        );  
        return view('cooperationnetwork', compact('data'));
    }  

    public function cooperationnetworkView($get_id)
    {
        $data=array(
            "get_id" => $get_id,
            "result" => cooperation_network::where('deleted_at', 0)->where('id', $get_id)->first(),
        );  
        return view('cooperationnetwork_view', compact('data'));
    }
}


