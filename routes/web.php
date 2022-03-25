<?php

use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\auth\AuthenticationController;
use App\Http\Controllers\auth\ForgotPasswordController;

use App\Http\Controllers\BookController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ResearchCortroller;
use App\Http\Controllers\LearningCortroller;
use App\Http\Controllers\JournalCortroller; 
use App\Http\Controllers\NewsCortroller; 
use App\Http\Controllers\ActivityCortroller; 
use App\Http\Controllers\ActiconservationCortroller; 
use App\Http\Controllers\SlideshowCortroller; 
use App\Http\Controllers\pages\PageseditCortroller; 
use App\Http\Controllers\ReportannualController; 
use App\Http\Controllers\NetworkController; 

Auth::routes(); 
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('about-history', [HomeController::class, 'aboutHistory'])->name('about.history'); 
Route::get('about-vision', [HomeController::class, 'aboutVision'])->name('about.vision'); 
Route::get('about-symbol', [HomeController::class, 'aboutSymbol'])->name('about.symbol');
Route::get('about-policy', [HomeController::class, 'aboutPolicy'])->name('about.policy'); 
Route::get('about-network', [HomeController::class, 'aboutNetwork'])->name('about.network');
Route::get('about-report', [HomeController::class, 'aboutReport'])->name('about.report');   
Route::get('admin-structure', [HomeController::class, 'adminStructure'])->name('admin.structure');  
Route::get('admin-commitee', [HomeController::class, 'adminCommitee'])->name('admin.commitee');  
Route::get('admin-executive', [HomeController::class, 'adminExecutive'])->name('admin.executive');  
Route::get('admin-personel', [HomeController::class, 'adminPersonel'])->name('admin.personel');  
Route::get('preserve-history', [HomeController::class, 'preserveHistory'])->name('preserve.history'); 
Route::get('preserve-duties', [HomeController::class, 'preserveDuties'])->name('preserve.duties'); 
Route::get('preserve-committee', [HomeController::class, 'preserveCommittee'])->name('preserve.committee');  
Route::get('contact', [HomeController::class, 'contact'])->name('contact');  

Route::get('book', [HomeController::class, 'book'])->name('book');  
Route::get('/book-view/{id}', [HomeController::class, 'bookView'])->name('book.view');   
Route::get('research', [HomeController::class, 'research'])->name('research');  
Route::get('/research-view/{id}', [HomeController::class, 'researchView'])->name('research.view');  
Route::get('learning', [HomeController::class, 'learning'])->name('learning');  
Route::get('/learning-view/{id}', [HomeController::class, 'learningView'])->name('learning.view');  
Route::get('news', [HomeController::class, 'news'])->name('news'); 
Route::get('/news-view/{id}', [HomeController::class, 'newsView'])->name('news.view');  
Route::get('acticonservation', [HomeController::class, 'acticonservation'])->name('acticonservation'); 
Route::get('/acticonservation-view/{id}', [HomeController::class, 'acticonservationView'])->name('acticonservation.view'); 
Route::get('journal', [HomeController::class, 'journal'])->name('journal');
Route::get('/journal-view/{id}', [HomeController::class, 'journalView'])->name('journal.view');  
Route::get('activity', [HomeController::class, 'activity'])->name('activity');
Route::get('/activity-view/{id}', [HomeController::class, 'activityView'])->name('activity.view');  
Route::get('reportannual', [HomeController::class, 'reportannual'])->name('reportannual'); 
Route::get('/reportannual-view/{id}', [HomeController::class, 'reportannualView'])->name('reportannual.view');  
Route::get('cooperationnetwork', [HomeController::class, 'cooperationnetwork'])->name('cooperationnetwork'); 
Route::get('/cooperationnetwork-view/{id}', [HomeController::class, 'cooperationnetworkView'])->name('cooperationnetwork.view');  

Route::middleware(['isusers'])->group(function () {  
    //Profile//
    Route::get('home', [ProfileController::class, 'home'])->name('home'); 
    Route::get('profile', [ProfileController::class, 'profile'])->name('profile'); 
    Route::post('save-profile', [ProfileController::class, 'saveprofile'])->name('save.profile'); 

    //Model Slideshow//
    Route::get('slideshow-list', [SlideshowCortroller::class, 'slideshowlist'])->name('slideshow.list'); 
    Route::get('datatable-slideshow', [SlideshowCortroller::class, 'datatableSlideshow'])->name('datatable.slideshow');
    Route::get('slideshow-add', [SlideshowCortroller::class, 'slideshowadd'])->name('slideshow.add'); 
    Route::get('/slideshow-edit/{id}', [SlideshowCortroller::class, 'slideshowedit'])->name('slideshow.edit'); 
    Route::post('close-slideshow', [SlideshowCortroller::class, 'closeSlideshow'])->name('close.slideshow');   
    Route::post('save-slideshow', [SlideshowCortroller::class, 'saveSlideshow'])->name('save.slideshow');
    
    //Model Roles//
    Route::get('roles-list', [RolesController::class, 'roleslist'])->name('roles.list');
    Route::get('roles-add', [RolesController::class, 'rolesadd'])->name('roles.add'); 
    Route::get('/roles-edit/{id}', [RolesController::class, 'rolesedit'])->name('roles.edit'); 
    Route::post('close-roles', [RolesController::class, 'closeRoles'])->name('close.roles');  
    Route::post('save-roles', [RolesController::class, 'saveRoles'])->name('save.roles');  
    Route::get('datatable-roles', [RolesController::class, 'datatableRoles'])->name('datatable.roles');

    //Model Book// 
    Route::get('book-list', [BookController::class, 'booklist'])->name('book.list'); 
    Route::get('datatable-book', [BookController::class, 'datatableBook'])->name('datatable.book');
    Route::get('book-add', [BookController::class, 'bookadd'])->name('book.add'); 
    Route::get('/book-edit/{id}', [BookController::class, 'bookedit'])->name('book.edit'); 
    Route::post('close-book', [BookController::class, 'closeBook'])->name('close.book');  
    Route::post('close-book-pdf', [BookController::class, 'closeBookPdf'])->name('close.book.pdf');  
    Route::post('save-book', [BookController::class, 'saveBook'])->name('save.book');
    
    //Model Research//
    Route::get('research-list', [ResearchCortroller::class, 'researchlist'])->name('research.list'); 
    Route::get('datatable-research', [ResearchCortroller::class, 'datatableResearch'])->name('datatable.research');
    Route::get('research-add', [ResearchCortroller::class, 'researchadd'])->name('research.add'); 
    Route::get('/research-edit/{id}', [ResearchCortroller::class, 'researchedit'])->name('research.edit'); 
    Route::post('close-research', [ResearchCortroller::class, 'closeResearch'])->name('close.research');  
    Route::post('close-research-pdf', [ResearchCortroller::class, 'closeResearchPdf'])->name('close.research.pdf');  
    Route::post('save-research', [ResearchCortroller::class, 'saveResearch'])->name('save.research');   

    //Model Learning//
    Route::get('learning-list', [LearningCortroller::class, 'learninglist'])->name('learning.list'); 
    Route::get('datatable-learning', [LearningCortroller::class, 'datatableLearning'])->name('datatable.learning');
    Route::get('learning-add', [LearningCortroller::class, 'learningadd'])->name('learning.add'); 
    Route::get('/learning-edit/{id}', [LearningCortroller::class, 'learningedit'])->name('learning.edit'); 
    Route::post('close-learning', [LearningCortroller::class, 'closeLearning'])->name('close.learning'); 
    Route::post('close-learning-pdf', [LearningCortroller::class, 'closeLearningPdf'])->name('close.learning.pdf'); 
    Route::post('save-learning', [LearningCortroller::class, 'saveLearning'])->name('save.learning');  
     
    Route::get('learningcategory-list', [LearningCortroller::class, 'learningcategorylist'])->name('learningcategory.list'); 
    Route::get('datatable-learningcategory', [LearningCortroller::class, 'datatableLearningcategory'])->name('datatable.learningcategory');
    Route::get('learningcategory-add', [LearningCortroller::class, 'learningcategoryadd'])->name('learningcategory.add'); 
    Route::get('/learningcategory-edit/{id}', [LearningCortroller::class, 'learningcategoryedit'])->name('learningcategory.edit'); 
    Route::post('close-learningcategory', [LearningCortroller::class, 'closeLearningcategory'])->name('close.learningcategory');  
    Route::post('save-learningcategory', [LearningCortroller::class, 'saveLearningcategory'])->name('save.learningcategory');  

    //Model Journal//
    Route::get('journal-list', [JournalCortroller::class, 'journallist'])->name('journal.list'); 
    Route::get('datatable-journal', [JournalCortroller::class, 'datatableJournal'])->name('datatable.journal');
    Route::get('journal-add', [JournalCortroller::class, 'journaladd'])->name('journal.add'); 
    Route::get('/journal-edit/{id}', [JournalCortroller::class, 'journaledit'])->name('journal.edit'); 
    Route::post('close-journal', [JournalCortroller::class, 'closeJournal'])->name('close.journal');  
    Route::post('save-journal', [JournalCortroller::class, 'saveJournal'])->name('save.journal');   
    Route::post('close-journal-pdf', [JournalCortroller::class, 'closeJournalPdf'])->name('close.journal.pdf');  

    //Model News//
    Route::get('news-list', [NewsCortroller::class, 'newslist'])->name('news.list'); 
    Route::get('datatable-news', [NewsCortroller::class, 'datatableNews'])->name('datatable.news');
    Route::get('news-add', [NewsCortroller::class, 'newsadd'])->name('news.add'); 
    Route::get('/news-edit/{id}', [NewsCortroller::class, 'newsedit'])->name('news.edit'); 
    Route::post('close-news', [NewsCortroller::class, 'closeNews'])->name('close.news');  
    Route::post('save-news', [NewsCortroller::class, 'saveNews'])->name('save.news');   
    Route::post('close-news-pdf', [NewsCortroller::class, 'closeNewsPdf'])->name('close.newspdf');  

    //Model Cooperation Network//
    Route::get('network-list', [NetworkController::class, 'networklist'])->name('network.list'); 
    Route::get('datatable-network', [NetworkController::class, 'datatableNetwork'])->name('datatable.network');
    Route::get('network-add', [NetworkController::class, 'networkadd'])->name('network.add'); 
    Route::get('/network-edit/{id}', [NetworkController::class, 'networkedit'])->name('network.edit'); 
    Route::post('close-network', [NetworkController::class, 'closeNetwork'])->name('close.network');  
    Route::post('save-network', [NetworkController::class, 'saveNetwork'])->name('save.network');   
    Route::post('close-network-pdf', [NetworkController::class, 'closeNetworkPdf'])->name('close.networkpdf');  

    //Model Annual//
    Route::get('annual-list', [ReportannualController::class, 'annuallist'])->name('annual.list'); 
    Route::get('datatable-annual', [ReportannualController::class, 'datatableAnnual'])->name('datatable.annual');
    Route::get('annual-add', [ReportannualController::class, 'annualadd'])->name('annual.add'); 
    Route::get('/annual-edit/{id}', [ReportannualController::class, 'annualedit'])->name('annual.edit'); 
    Route::post('close-annual', [ReportannualController::class, 'closeAnnual'])->name('close.annual');  
    Route::post('save-annual', [ReportannualController::class, 'saveAnnual'])->name('save.annual');   
    Route::post('close-annual-pdf', [ReportannualController::class, 'closeAnnualPdf'])->name('close.annualpdf');  

    //Model Activity//
    Route::get('activity-list', [ActivityCortroller::class, 'activitylist'])->name('activity.list'); 
    Route::get('datatable-activity', [ActivityCortroller::class, 'datatableActivity'])->name('datatable.activity');
    Route::get('activity-add', [ActivityCortroller::class, 'activityadd'])->name('activity.add'); 
    Route::get('/activity-edit/{id}', [ActivityCortroller::class, 'activityedit'])->name('activity.edit'); 
    Route::post('close-activity', [ActivityCortroller::class, 'closeActivity'])->name('close.activity');  
    Route::post('save-activity', [ActivityCortroller::class, 'saveActivity'])->name('save.activity');   
    Route::post('close-activity-pdf', [ActivityCortroller::class, 'closeActivityPdf'])->name('close.activity.pdf');  
    Route::post('close-activity-galleries', [ActivityCortroller::class, 'closeActivityGalleries'])->name('close.activity.galleries');  
    
    //Model Activity Conservation//
    Route::get('acticonservation-list', [ActiconservationCortroller::class, 'acticonservationlist'])->name('acticonservation.list'); 
    Route::get('datatable-acticonservation', [ActiconservationCortroller::class, 'datatableActiconservation'])->name('datatable.acticonservation');
    Route::get('acticonservation-add', [ActiconservationCortroller::class, 'acticonservationadd'])->name('acticonservation.add'); 
    Route::get('/acticonservation-edit/{id}', [ActiconservationCortroller::class, 'acticonservationedit'])->name('acticonservation.edit'); 
    Route::post('close-acticonservation', [ActiconservationCortroller::class, 'closeActiconservation'])->name('close.acticonservation');  
    Route::post('save-acticonservation', [ActiconservationCortroller::class, 'saveActiconservation'])->name('save.acticonservation'); 
    Route::post('close-acticonservation-pdf', [ActiconservationCortroller::class, 'closeActiconservationPdf'])->name('close.acticonservation.pdf');  
    Route::post('close-acticonservation-galleries', [ActiconservationCortroller::class, 'closeActiconservationGalleries'])->name('close.Acticonservation.galleries');  
    
    //Model Recommend the agency //
    Route::get('/pages-edit/{id}', [PageseditCortroller::class, 'pagesedit'])->name('pagesedit'); 
    Route::post('save-pages', [PageseditCortroller::class, 'savePages'])->name('save.pages');  
    Route::post('close-pages-pdf', [PageseditCortroller::class, 'closePagesPdf'])->name('close.pages.pdf');  
});

// Login & Register //
Route::get('/login', [AuthenticationController::class, 'login'])->name('login'); 
Route::post('login-check', [AuthenticationController::class, 'logincheck'])->name('login-check'); 
Route::post('signOut', [AuthenticationController::class, 'signOut'])->name('signOut');
Route::get('/register', [AuthenticationController::class, 'register'])->name('register')->middleware('isusers');
Route::post('registration', [AuthenticationController::class, 'registration'])->name('registration')->middleware('isusers'); 

// Forget //
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
 