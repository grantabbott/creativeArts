@extends('layouts.default')

	@section('content')
		<div class="row">
        
			<div class="col-sm-6">
				<div class="box-info">
					<h2><strong>Ticket # {!! $ticket->ticket_no !!}</strong> <span class="pull-right show-info" style="color:#000;">Created at {!! \App\Classes\Helper::showDateTime($ticket->created_at) !!}</span></h2>
        
          <h4>{!! $ticket->ticket_subject !!}</h4>
          <div class="comment-widget">
            <ul class="media-list">
              <li class="media">
                <a class="pull-left">{!! \App\Classes\Helper::getAvatar($ticket->User->id) !!}</a>
                <div class="media-body danger">
                  {!! $ticket->ticket_description !!}
                </div>
              </li>
              @foreach($ticket->TicketResponse as $response)
              <li class="media">
                <a class="pull-{!! ($response->User->hasRole('user')) ? 'left' : 'right' !!}">{!! \App\Classes\Helper::getAvatar($response->User->id) !!}</a>
                <div class="media-body {!! ($response->User->hasRole('user')) ? 'danger' : 'success' !!}">
                  {!! $response->response_description !!}
                  
                  @if(isset($response->attachments))
                    <?php $files = explode(',',$response->attachments); ?>
                    @foreach($files as $file)
                      <p class="time-left"><i class="fa fa-paperclip"></i> <a href="{!! URL::to('/uploads/response_attachment/'.$file) !!}">{!! $file !!}</a></p>
                    @endforeach
                  @endif
                  
                  <p class="time">{!! \App\Classes\Helper::showDateTime($response->created_at) !!}</p>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
          <h2><strong>Send</strong> Reply</h2>
          
          {!! Form::model($ticket,['method' => 'PATCH','route' => ['ticket.response',$ticket->id] ,'class' => 'ticket-reply-form', 'files'=>true]) !!}
          
          <div class="form-group">
            {!! Form::label('template',trans('messages.Template'),[])!!}
          {!! Form::select('template', ['' => ''] + $template_list,'',['class'=>'form-control input-xlarge select2me template','placeholder'=>'Select Template'])!!}
          </div>
          <div class="form-group">
            {!! Form::label('mail_subject',trans('messages.Subject'),[])!!}
            {!! Form::textarea('mail_subject','',['id'=> 'mail_subject', 'size' => '30x1', 'class' => 'form-control mail_subject', 'placeholder' => 'Enter Mail Subject'])!!}
          </div>
          <div class="form-group">
            {!! Form::textarea('response_description','',['id'=> 'response_description', 'class' => 'form-control summernote', 'placeholder' => 'Enter Response Content'])!!}
          </div>
          <div class="form-group">
            <input type="file" name="file[]" id="file" class="btn btn-default" title="Select Files" multiple="true">
          </div>
          <div class="form-group">
            {!! Form::label('ticket_status',trans('messages.Change Status'),['class' => 'control-label'])!!}
            {!! Form::select('ticket_status', [null=>'Select One'] + $ticket_status
                , isset($ticket->ticket_status) ? $ticket->ticket_status : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Status'])!!}
          </div>
          <div class="form-group">
            <div class="checkbox">
            <label>
              <input type="checkbox" name="send_mail" value="1" checked> Send to Mail
            </label>
            @if(!$ticket->responded)
            <label>
              <input type="checkbox" name="set_response_time" value="1" > Mark as Responded
            </label>
            @endif
            <label>
              <input type="checkbox" name="set_resolution_time" value="1" > Mark as Resolved
            </label>
            </div>
          </div>
          {!! Form::hidden('type','ticket') !!}
          {!! Form::hidden('id',$ticket->id) !!}
          {!! Form::submit(trans('messages.Send'),['class' => 'btn btn-primary']) !!}
          {!! Form::close() !!}

				</div>
			</div>

			<div class="col-sm-6">
				<div class="box-info full">
          <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="#detail" data-toggle="tab"><i class="fa fa-arrows"></i> Detail</a></li>
            <li><a href="#comment" data-toggle="tab"><i class="fa fa-comment"></i> Comment</a></li>
            <li><a href="#notes" data-toggle="tab"><i class="fa fa-pencil"></i> Notes</a></li>
            <li><a href="#attachments" data-toggle="tab"><i class="fa fa-paperclip"></i> Attachments</a></li>
          </ul>
          <div class="tab-content">
              <div class="tab-pane animated active fadeInRight" id="detail">
                  <div class="user-profile-content">
                    
                  <p><i class="fa fa-calendar"></i> Response Time Due at 
                    <span class="pull-right">
                      {!! \App\Classes\Helper::ticketTime($ticket_array,'response') !!}
                      {!! \App\Classes\Helper::showDateTime($ticket->response_due_time) !!}
                    </span>
                  </p>
                  <p><i class="fa fa-calendar"></i> Resolution Time Due at 
                    <span class="pull-right">
                      {!! \App\Classes\Helper::ticketTime($ticket_array,'resolution') !!}
                      {!! \App\Classes\Helper::showDateTime($ticket->resolution_due_time) !!}
                    </span>
                  </p>
                  
                    <div class="col-md-6">
                      <h2><strong>Assigned</strong> Staff</h2>
                      @foreach($ticket_with_user->assignedUser as $user)
                        @include('auth.user_detail',['user' => $user, 'role' => 1, 'email' => 1])
                      @endforeach
                    </div>

                    <div class="col-md-6">
                      <h2><strong>Ticket</strong> Property</h2>
                      {!! Form::model($ticket,['method' => 'PATCH','route' => ['ticket.update',$ticket->id] ,'class' => 'ticket-property-form']) !!}
                        <div class="form-group">
                          {!! Form::label('user_id',trans('messages.Assign'),['class' => 'control-label'])!!}
                          {!! Form::select('user_id[]', $users, isset($selected_users) ? $selected_users : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select User','multiple' => true])!!}
                        </div>
                        <div class="form-group">
                          {!! Form::label('department_id',trans('messages.Department'),['class' => 'control-label'])!!}
                          {!! Form::select('department_id', [null=>'Select One'] + $departments
                              , isset($ticket->department_id) ? $ticket->department_id : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Department'])!!}
                        </div>
                        <div class="form-group">
                          {!! Form::label('ticket_type_id',trans('messages.Type'),['class' => 'control-label'])!!}
                          {!! Form::select('ticket_type_id', [null=>'Select One'] + $ticket_types
                              , isset($ticket->ticket_type_id) ? $ticket->ticket_type_id : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Type'])!!}
                        </div>
                        <div class="form-group">
                          {!! Form::label('ticket_priority',trans('messages.Priority'),['class' => 'control-label'])!!}
                          {!! Form::select('ticket_priority', [null=>'Select One'] + $priorities
                              , isset($ticket->ticket_priority) ? $ticket->ticket_priority : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Priority'])!!}
                        </div>
                        {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Update'),['class' => 'btn btn-primary']) !!}
                      {!! Form::close() !!}
                    </div>

                    <div class="clear"></div>
                  </div>
              </div>
              <div class="tab-pane animated fadeInRight" id="comment">
                  <div class="user-profile-content">
                    {!! Form::open(['route' => 'comment.store','role' => 'form', 'class'=>'comment-form']) !!}
                      <div class="form-group">
                        {!! Form::textarea('comment','',['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Enter Comment'])!!}
                      </div>
                      {!! Form::hidden('unique_id',$ticket->id) !!}
                      {!! Form::hidden('belongs_to','ticket') !!}
                      {!! Form::submit('Save',['class' => 'btn btn-primary pull-right']) !!}
                    {!! Form::close() !!}

                    <h2><strong>Comment</strong> List</h2>
                    <div class="scroll-widget">
                      <ul class="media-list">
                      @foreach($comments as $comment)
                        <li class="media">
                          <a class="pull-left" href="#fakelink">
                            {!! App\Classes\Helper::getAvatar($comment->user_id) !!}
                          </a>
                          <div class="media-body">
                            <h4 class="media-heading"><a href="#fakelink">{!! $comment->User->name !!}</a> <small>{!! App\Classes\Helper::showDateTime($comment->created_at) !!}</small></h4>
                            <p>{!! $comment->comment !!}</p>

                            @if(Entrust::hasRole('admin') || Auth::user()->id == $comment->user_id)
                            {!! Form::open(array('route' => array('comment.destroy', $comment->id), 'method' => 'delete')) !!}
                                  <button type="submit" class="btn btn-danger btn-xs pull-right" data-submit-confirm-text = "Yes"><i class="fa fa-trash"></i> Delete</button>
                            {!! Form::close() !!}
                            @endif
                          </div>
                        </li>
                      @endforeach
                      </ul>
                    </div>
                  </div>
              </div>
              <div class="tab-pane animated fadeInRight" id="notes">
                  <div class="user-profile-content">
                    @if(isset($note->id))
                      {!! Form::open(['method' => 'PUT','route' => ['note.update', $note->id],'class' => 'note-form']) !!}
                    @else
                      {!! Form::open(['method' => 'POST','route' => ['note.store'],'class' => 'note-form']) !!}
                    @endif
                       <div class="form-group">
                        {!! Form::textarea('note',isset($note->note) ? $note->note : '',['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Enter Comment'])!!}
                       </div>
                      {!! Form::hidden('unique_id',$ticket->id) !!}
                      {!! Form::hidden('belongs_to','ticket') !!}
                      {!! Form::submit('Save',['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                  </div>
              </div>
              <div class="tab-pane animated fadeInRight" id="attachments">
                  <div class="user-profile-content">
                    {!! Form::open(['files'=>'true','route' => 'attachment.store','role' => 'form', 'class'=>'attachment-form']) !!}
                      <div class="form-group">
                        {!! Form::label('file_title','Title',[])!!}
                      {!! Form::input('text','file_title','',['class'=>'form-control','placeholder'=>'Enter Title'])!!}
                      </div>
                      <div class="form-group">
                        <input type="file" name="file" id="file" class="btn btn-default" title="Select File">
                      </div>
                      <div class="form-group">
                        {!! Form::textarea('file_description','',['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Enter Description'])!!}
                      </div>
                      {!! Form::hidden('unique_id',$ticket->id) !!}
                      {!! Form::hidden('belongs_to','ticket') !!}
                      {!! Form::submit('Save',['class' => 'btn btn-primary pull-right']) !!}  
                    {!! Form::close() !!}
                    <h2><strong>Attachment</strong> List</h2>
                    <div class="table-responsive">
                      <table class="table table-hover table-striped">
                        <thead>
                          <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>File</th>
                            <th>Date & Time</th>
                            <th>Option</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($attachments as $attachment)
                            <tr>
                              <td>{!! $attachment->file_title !!}</td>
                              <td>{!! $attachment->file_description !!}</td>
                              <td><a href="{!! URL::to('/uploads/attachment_files/'.$attachment->file) !!}">Click Here</a></td>
                              <td>{!! App\Classes\Helper::showDateTime($attachment->created_at) !!}</td>
                              <td>
                                @if(Entrust::hasRole('admin') || Auth::user()->id == $attachment->use_id)
                                {!! Form::open(array('route' => array('attachment.destroy', $attachment->id), 'method' => 'delete')) !!}
                                      <button type="submit" class="btn btn-danger btn-xs pull-right" data-submit-confirm-text = "Yes"><i class="fa fa-trash"></i> Delete</button>
                                  {!! Form::close() !!}
                                    @endif
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
          </div>
        </div>
        @if(count($custom_field_values))
        <div class="box-info">
        <h2>Custom Fields</h2>
          {!! Form::model($ticket,['method' => 'PATCH','route' => ['ticket.update',$ticket->id] ,'class' => 'ticket-form']) !!}
            {{ App\Classes\Helper::getCustomFields('ticket-form',$custom_field_values) }}
            
            {!! Form::submit(trans('messages.Save'),['class' => 'btn btn-primary']) !!}
            
          {!! Form::close() !!}
        </div>
        @endif
      </div>
    </div>
	@stop