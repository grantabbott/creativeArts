<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use Response;
use Spatie\Activitylog\Models\Activity;
use DB;
use Auth;
use Entrust;
use App\KbCategory;
use App\Holiday;
use App\BusinessHour;
use App\KbArticle;
use App\Annoucement;
use App\Classes\Helper;

class DashboardController extends Controller
{
   public function index(Request $request){

      $start_date = ($request->input('start_date')) ? : date('Y-m-d',strtotime('-30 days'));
      $end_date = ($request->input('end_date')) ? : date('Y-m-d',strtotime(date('Y-m-d')));

      if(Entrust::hasRole('user'))
        return redirect('/')->withErrors(config('constants.NA'));

      $user_count = \App\User::with('roles')
        ->whereHas('roles',function($query) {
            $query->whereName('user');
        })->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)
        ->count();

      $staff_count = \App\User::with('roles')
        ->whereHas('roles',function($query) {
            $query->where('name','!=','user');
        })->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)
        ->count();

      $ticket_count = \App\Ticket::where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->count();
      $closed_ticket_count = \App\Ticket::where('ticket_status','=','close')->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->count();

      $closed_ticket_percentage = ($ticket_count > 0) ? round(($closed_ticket_count / $ticket_count) * 100,2) : 0;

      $ticket_status_stats = \App\Ticket::select('ticket_status', DB::raw('count(*) as total'))
                 ->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)
                 ->groupBy('ticket_status')
                 ->get();

      $status_stats = array();
      foreach($ticket_status_stats as $stat)
        $status_stats[] = array('label' => Helper::toWord($stat->ticket_status), 'value' => $stat->total);
                 
      $ticket_priority_stats = \App\Ticket::select('ticket_priority', DB::raw('count(*) as total'))
                 ->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)
                 ->groupBy('ticket_priority')
                 ->get();

      $priority_stats = array();
      foreach($ticket_priority_stats as $stat)
        $priority_stats[] = array('label' => Helper::toWord($stat->ticket_priority), 'value' => $stat->total);
                 
      $ticket_type_status = \App\Ticket::select('ticket_type_id', DB::raw('count(*) as total'))
                 ->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)
                 ->groupBy('ticket_type_id')
                 ->get();

      $type_stats = array();
      foreach($ticket_type_status as $stat)
        $type_stats[] = array('label' => Helper::toWord($stat->TicketType->ticket_type_name), 'value' => $stat->total);
                 
      $ticket_department_stats = \App\Ticket::select('department_id', DB::raw('count(*) as total'))
                 ->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)
                 ->groupBy('department_id')
                 ->get();

      $department_stats = array();
      foreach($ticket_department_stats as $stat)
        $department_stats[] = array('label' => Helper::toWord($stat->Department->department_name), 'value' => $stat->total);
                 

      $users = \App\User::with('roles')
        ->whereHas('roles',function($query) {
          $query->where('name','!=','user');
        })->where('id','!=',Auth::user()->id)->get();

      $user_list = array();
      foreach($users as $user)
        $user_list[$user->id] = $user->name.' (Department : '.$user->Profile->Department->department_name.')';

      $query = DB::table('activity_log')
          ->join('users','users.id','=','activity_log.user_id')
          ->select(DB::raw('name,activity_log.created_at AS created_at,text,user_id'));

      if(!Entrust::hasRole('admin'))
          $query->where('user_id','=',Auth::user()->id);
      
      $activities = $query->latest()->limit(100)->get();

      $holidays = \App\Holiday::all();
      $todos = \App\Todo::where('user_id','=',Auth::user()->id)
          ->orWhere(function ($query)  {
              $query->where('user_id','!=',Auth::user()->id)
                  ->where('visibility','=','public');
          })->get();

      $events = array();
      foreach($holidays as $holiday){
          $start = $holiday->date;
          $title = 'Holiday: '.$holiday->holiday_description;
          $color = '#1e5400';
          $events[] = array('title' => $title, 'start' => $start, 'color' => $color);
      }
      foreach($todos as $todo){
          $start = $todo->date;
          $title = 'To do: '.$todo->todo_title.' '.$todo->todo_description;
          $color = '#ff0000';
          $url = '/todo/'.$todo->id.'/edit';
          $events[] = array('title' => $title, 'start' => $start, 'color' => $color, 'url' => $url);
      }

      $colors = ['#5CB85C', '#FFD600', '#D10D0D', '#1A89E8','#458b00', '#f85931', '#ce1836', '#009989','#00688b','#8b1a1a'];

      shuffle($colors);
      $status_colors = $colors;
      shuffle($colors);
      $priority_colors = $colors;
      shuffle($colors);
      $type_colors = $colors;
      shuffle($colors);
      $department_colors = $colors;

      $assets = ['calendar','graph'];

      return view('dashboard',compact(
          'user_count','staff_count','assets','activities','user_list','holidays','events','ticket_count',
          'closed_ticket_percentage','status_stats','priority_stats','type_stats','department_stats','status_colors',
          'priority_colors','type_colors','department_colors','start_date','end_date'
          ));
   }

   public function search(Request $request){
      $q = $request->input('q');

      if(!isset($q) || $q == '')
        return redirect('/')->withErrors('Please enter any search term.');

      $kb_articles = KbArticle::where(function ($query) {
          $query->where('published','=',1);
        })->where(function ($query) use($q) {
          $query->where('kb_article_title','LIKE','%'.$q.'%')
            ->orWhere('kb_article_description','LIKE','%'.$q.'%');
        })->get();

      $kb_categories = KbCategory::all();

      $assets = ['hide_sidebar'];
      return view('kb_article.search',compact('q','kb_articles','assets','kb_categories'));
   }

   public function home(){

      $q = Annoucement::with('role')
          ->where(function($query){
                $query->where('start_date','<=',date('Y-m-d'))
                ->where('end_date','>=',date('Y-m-d'));
          });

      if(!Auth::check())
        $q->where('for_all','=',1);
      else {
        foreach(Auth::user()->roles as $role)
          $role_id = $role->id;

        $q->where(function($query) use ($role_id){
            $query->where('for_all','=',1)
            ->orWhere(function ($query1) use ($role_id)  {
              $query1->whereHas('role',function($query2) use($role_id) {
                $query2->where('role_id','=',$role_id);
              });
            });
        });
      }

      $annoucements = $q->get();

      $assets = ['hide_sidebar'];
      return view('home',compact('assets','annoucements'));
   }

   public function uploadFiles(UploadRequest $request){

        $destinationPath = 'uploads';
        $extension = $request->file('file')->getClientOriginalExtension();
        $fileName = rand(11111, 99999) . '.' . $extension;
        $upload_success = $request->file('file')->move($destinationPath, $fileName);
 
        if ($upload_success) {
            return Response::json(array('success' => true, 'message' => 'Successfully uploaded file.'), 200);
        } else {
            return Response::make(array('success' => false, 'message' => 'Error while uploading file.'), 400);
        }
   }
}