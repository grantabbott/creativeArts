<?php
namespace App\Http\Controllers;
use App\Classes\Helper;
use App\Ticket;
use App\Department;
use App\TicketType;
use App\ServiceTime;
use App\TicketResponse;
use App\User;
use Validator;
use DB;
use File;
use Activity;
use Auth;
use Mail;
use Entrust;
use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;

Class TicketController extends Controller{

	protected $form = 'ticket-form';

	public function index(Ticket $ticket, Request $request){

		if(!Entrust::can('manage_ticket'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		if(Entrust::hasRole('admin'))
			$query = $ticket::with('assignedUser');
		else
			$query = $ticket::with('assignedUser')
				->whereHas('assignedUser',function($query) {
					$query->where('user_id','=',Auth::user()->id);
				});

		if($request->input('department_id'))
			$query->where('department_id','=',$request->input('department_id'));

		if($request->input('ticket_type_id'))
			$query->where('ticket_type_id','=',$request->input('ticket_type_id'));

		if($request->input('ticket_priority'))
			$query->where('ticket_priority','=',$request->input('ticket_priority'));

		if($request->input('ticket_status'))
			$query->where('ticket_status','=',$request->input('ticket_status'));

		if($request->input('response_time_overdue'))
			$query->where('response_due_time','<',date('d M Y, H:i'));

		if($request->input('resolution_time_overdue'))
			$query->where('resolution_due_time','<',date('d M Y, H:i'));

		if($request->input('start_date'))
			$query->where('created_at','>=',$request->input('start_date'));

		if($request->input('end_date'))
			$query->where('created_at','<=',$request->input('end_date'));

		if($request->input('assigned') == 'assigned' )
			$query->Has('assignedUser');
		elseif($request->input('assigned') == 'unassigned')
			$query->doesntHave('assignedUser');

		if($request->input('user_id')){
			$query->whereHas('assignedUser',function($query1) use($request) {
					$query1->whereIn('user_id',$request->input('user_id'));
				});
		}

		$filter_data = [
			'start_date' => $request->input('start_date'),
			'end_date' => $request->input('end_date'),
			'assigned' => $request->input('assigned'),
			'department_id' => $request->input('department_id'),
			'ticket_type_id' => $request->input('ticket_type_id'),
			'ticket_priority' => $request->input('ticket_priority'),
			'ticket_status' => $request->input('ticket_status'),
			'user_id' => $request->input('user_id'),
			'response_time_overdue' => $request->input('response_time_overdue'),
			'resolution_time_overdue' => $request->input('resolution_time_overdue'),
			];

		$tickets = $query->get();

        $col_data=array();
        $col_heads = array(
        		trans('messages.Option'),
        		trans('messages.Ticket #'),
        		trans('messages.Name'),
        		trans('messages.Subject'),
        		trans('messages.Response Time'),
        		trans('messages.Resolution Time'),
        		trans('messages.Priority'),
        		trans('messages.Status'));

        $col_heads = Helper::putCustomHeads($this->form, $col_heads);
        $col_ids = Helper::getCustomColId($this->form);
        $values = Helper::fetchCustomValues($this->form);

        foreach($tickets as $ticket){

			$cols = array(
					'<div class="btn-group btn-group-xs">'.
					'<a href="/ticket/'.$ticket->id.'" class="btn btn-default btn-xs" data-toggle="tooltip" title="View"> <i class="fa fa-share"></i></a> '.
					'<a href="/ticket/'.$ticket->id.'/edit" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit"> <i class="fa fa-edit"></i></a> '.
					delete_form(['ticket.destroy',$ticket->id]).'</div>',
					$ticket->ticket_no,
					$ticket->User->name,
					$ticket->ticket_subject,
					((strtotime($ticket->response_due_time) < time()) ? '<span class="badge badge-danger">Overdue</span> ' : '').Helper::showDateTime($ticket->response_due_time),
					((strtotime($ticket->resolution_due_time) < time()) ? '<span class="badge badge-danger">Overdue</span> ' : '').Helper::showDateTime($ticket->resolution_due_time),
					Helper::showTicketPriority($ticket->ticket_priority),
					Helper::showTicketStatus($ticket->ticket_status)
					);	
			$id = $ticket->id;

			foreach($col_ids as $col_id)
				array_push($cols,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
        	$col_data[] = $cols;
        }

		$departments = Department::lists('department_name','id')->all();
		$ticket_types = TicketType::lists('ticket_type_name','id')->all();
        Helper::writeResult($col_data);

        $users = User::with('roles')
        	->whereHas('roles',function ($query) {
        		$query->where('roles.name','!=','user');
        	})->lists('name','id')->all();

		return view('ticket.index',compact(
				'col_heads',
				'departments',
				'ticket_types',
				'filter_data',
				'users'
				));
	}

	public function show(Ticket $ticket){

		if(!Entrust::can('view_ticket'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		if(!Entrust::hasRole('admin')){
			$ticket = $ticket->with('assignedUser')->whereId($ticket->id)
				->whereHas('assignedUser',function($query) {
					$query->where('user_id','=',Auth::user()->id);
				})->first();
		}

		if(!$ticket)
			return redirect('/ticket')->withErrors('You cannot access a ticket without permission.');

		$departments = Department::lists('department_name','id')->all();
		$ticket_types = TicketType::lists('ticket_type_name','id')->all();
        $priorities = config('list.priority');
        $ticket_status = config('list.ticket_status');

        $comments = \App\Comment::whereBelongsTo('ticket')
        	->whereUniqueId($ticket->id)->get();
        $note = \App\Note::whereBelongsTo('ticket')
        	->whereUniqueId($ticket->id)->first();
        $attachments = \App\Attachment::whereBelongsTo('ticket')
        	->whereUniqueId($ticket->id)->get();

        $ticket_array = $ticket->toArray();

        $users = User::with('roles')
        	->whereHas('roles',function ($query) {
        		$query->where('roles.name','!=','user');
        	})->lists('name','id')->all();

        $ticket_with_user = $ticket->whereId($ticket->id)->with('assignedUser')->first();

        $selected_users = array();
        foreach($ticket_with_user->assignedUser as $user){
        	$selected_users[] = $user->id;
        }

		$custom_field_values = Helper::getCustomFieldValues($this->form,$ticket->id);
		$template_list = array();
		$templates = Helper::getTemplate();
		foreach($templates as $key => $template){
			if($key != 'forgot_password' && $template['category'] == 'ticket')
				$template_list[$key] = $template['title'];
		}

		return view('ticket.show',compact(
				'ticket',
				'departments',
				'ticket_types',
				'priorities',
				'users',
				'selected_users',
				'ticket_with_user',
				'ticket_array',
				'ticket_status',
				'comments',
				'note',
				'attachments',
				'custom_field_values',
				'template_list'
				));
	}

	public function view($id){

		if(Entrust::hasRole('user'))
			$ticket = Ticket::whereId($id)->where('user_id','=',Auth::user()->id)->first();
		else
			$ticket = Ticket::whereId($id)->first();

		if(!$ticket)
			return redirect('/')->withErrors(config('constants.NA'));

        $ticket_array = $ticket->toArray();
		$assets = ['hide_sidebar'];
		return view('ticket.view',compact(
				'ticket',
				'assets',
				'ticket_array'
				));
	}
	public function response($id, Request $request){

		$ticket = Ticket::find($id);

		if(!$ticket)
			return redirect('/')->withErrors(config('constants.NA'));

		$files = $request->file('file');
	    $file_count = count($files);

	    if($request->hasFile('file') && $file_count > config('config.max_file_upload_at_once'))
	    	return redirect()->back()->withErrors('Max '.config('config.max_file_upload_at_once').' files are allowed to upload at once.');
	    $uploadcount = 0;
	    $uploaded_file = array();
	    if($request->hasFile('file'))
	    foreach($files as $file) {
	      $filename = uniqid();
	      $rules = array('file' => 'mimes:'.config('config.allowed_upload_file')); 
	      $validator = Validator::make(array('file'=> $file), $rules);
	      if($validator->passes()){
	        $destinationPath = 'uploads/response_attachment';
	        $name = $file->getClientOriginalName();
	 		$extension = $file->getClientOriginalExtension();
	        $upload_success = $file->move($destinationPath, $filename.".".$extension);
	        $uploaded_file[] = $filename.'.'.$extension;
	        $uploadcount ++;
	      }
	    }

	    if($file_count > 0 && $uploadcount == 0 && $request->hasFile('file'))
	    	return redirect()->back()->withErrors('Only some files are allowed.');

		$ticket_response = new TicketResponse;
		if($uploadcount > 0)
			$ticket_response->attachments = implode(',',$uploaded_file);
		
		$title = $request->input('mail_subject');
		$content = $request->input('response_description');
		$ticket_response->response_description = $content;
		$ticket_response->user_id = Auth::user()->id;
		$ticket_response->ticket_id = $id;
		$ticket_response->set_response_time = ($request->input('set_response_time')) ? time() : null;
		$ticket_response->set_resolution_time = ($request->input('set_resolution_time')) ? time() : null;
		$ticket_response->save();

		if($ticket_response->set_response_time)
			$ticket->responded = 1;
		if($ticket_response->set_resolution_time)
			$ticket->resolved = 1;
		$ticket->ticket_status = $request->input('ticket_status');

		$ticket->save();

		if($request->input('send_mail'))
	    Mail::send('template.mail', compact('content'), function($message) use ($ticket,$title){
	        $message->to($ticket->User->email)->subject($title);
	    });

		return redirect()->back()->withSuccess('Ticket reply sent.');
	}

	public function create(){

		if(!Entrust::can('create_ticket'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$departments = Department::lists('department_name','id')->all();
		$ticket_types = TicketType::lists('ticket_type_name','id')->all();
        $priorities = config('list.priority');

		return view('ticket.create',compact('departments','ticket_types','priorities'));
	}

	public function edit(Ticket $ticket){

		if(!Entrust::can('edit_ticket'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$departments = Department::lists('department_name','id')->all();
		$ticket_types = TicketType::lists('ticket_type_name','id')->all();
        $priorities = config('list.priority');
		$custom_field_values = Helper::getCustomFieldValues($this->form,$ticket->id);

		return view('ticket.edit',compact('ticket','departments','ticket_types','priorities','custom_field_values'));
	}

	public function createTicket(){

		if(!Entrust::can('create_ticket'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$departments = Department::lists('department_name','id')->all();
		$ticket_types = TicketType::lists('ticket_type_name','id')->all();

		$tickets = Ticket::where('user_id','=',Auth::user()->id)->get();

		$assets = ['hide_sidebar'];
		return view('ticket.create-ticket',compact('departments',
				'ticket_types',
				'assets',
				'tickets'));
	}

	public function store(TicketRequest $request, Ticket $ticket){	

		if(!Entrust::can('create_ticket'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$data = $request->all();
	    $ticket->fill($data);
	    $ticket->ticket_status = 'open';
	    $ticket->user_id = Auth::user()->id;

	    $service_time = Helper::getServiceTime($ticket->ticket_priority);

	    if($service_time['resolution_time_type'] == 'business_hour')
		    $ticket->resolution_due_time = Helper::calculateDueTime($service_time['resolution_time'], date('Y-m-d H:i'));
		else
			$ticket->resolution_due_time = date('Y-m-d H:i',(($service_time['resolution_time'] * 60) + strtotime(date('Y-m-d H:i'))));

	    if($service_time['response_time_type'] == 'business_hour')
	    	$ticket->response_due_time = Helper::calculateDueTime($service_time['response_time'], date('Y-m-d H:i'));
		else
			$ticket->response_due_time = date('Y-m-d H:i',(($service_time['response_time'] * 60) + strtotime(date('Y-m-d H:i'))));

	    $max_ticket_no = Ticket::max('ticket_no');
	    $next_ticket_no = config('config.next_ticket_no');

	    if($max_ticket_no >= $next_ticket_no)
	    	$ticket->ticket_no = ++$max_ticket_no;
	    else
	    	$ticket->ticket_no = $next_ticket_no;

		$ticket->save();

		Helper::storeCustomField($this->form,$ticket->id, $data);

		$activity = 'New Ticket added';
		Activity::log($activity);

		$path = base_path().'/config/template/'.config('config.domain').'/new_ticket';
		$content = '';
		if(File::exists($path))
		$content = File::get($path);
		$content = Helper::templateContent($content,'ticket',$ticket);
		if($content != '' && config('config.new_ticket_send_mail')){
			$title = Helper::templateContent(config('template.new_ticket.title'),'ticket',$ticket);
		    Mail::send('template.mail', compact('content'), function($message) use ($ticket,$title){
		        $message->to($ticket->User->email)->subject($title);
		    });
		}

		if(Entrust::hasRole('user'))
		return redirect('/view-ticket/'.$ticket->id)->withSuccess(config('constants.ADDED'));
		else	
		return redirect('/ticket/'.$ticket->id)->withSuccess(config('constants.ADDED'));		
	}

	public function update(TicketRequest $request, Ticket $ticket){

		if(!Entrust::can('edit_ticket'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

        $data = $request->except('user_id');
		$ticket->fill($data)->save();

	    $service_time = Helper::getServiceTime($ticket->ticket_priority);

	    if($service_time['resolution_time_type'] == 'business_hour')
		    $ticket->resolution_due_time = Helper::calculateDueTime($service_time['resolution_time'], $ticket->created_at);
		else
			$ticket->resolution_due_time = date('Y-m-d H:i',(($service_time['resolution_time'] * 60) + strtotime($ticket->created_at)));

	    if($service_time['response_time_type'] == 'business_hour')
	    	$ticket->response_due_time = Helper::calculateDueTime($service_time['response_time'], $ticket->created_at);
		else
			$ticket->response_due_time = date('Y-m-d H:i',(($service_time['response_time'] * 60) + strtotime($ticket->created_at)));

		$ticket->save();
		Helper::updateCustomField($this->form,$ticket->id, $data);

	    $ticket->assignedUser()->sync(($request->input('user_id')) ? : []);
		return redirect()->back()->withSuccess(config('constants.ADDED'));	
	}

	public function destroy(Ticket $ticket){

		if(!Entrust::can('delete_ticket'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		Helper::deleteCustomField($this->form, $ticket->id);
        $ticket_no = $ticket->ticket_no;
        $ticket->delete();
		$activity = 'Deleted a ticket # '. $ticket_no;
		Activity::log($activity);

        return redirect('/ticket')->withSuccess(config('constants.DELETED'));
	}
}
?>