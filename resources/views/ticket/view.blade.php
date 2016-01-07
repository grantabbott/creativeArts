@extends('layouts.full')

    @section('content')
        <div class="row">
            
            <div class="col-md-8">
                <div class="box-info">
                    <h2><strong>Ticket # {!! $ticket->ticket_no !!} : {!! $ticket->ticket_subject !!} </strong></h2>

          			<div class="comment-widget">
			            <ul class="media-list">
			              <li class="media">
			                <a class="pull-left">{!! \App\Classes\Helper::getAvatar($ticket->User->id) !!}</a>
			                <div class="media-body danger">
			                  {!! $ticket->ticket_description !!}
			                  <p class="time">{!! \App\Classes\Helper::showDateTime($ticket->created_at) !!}</p>
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
			                      <p class="time-left"><i class="fa fa-paperclip"></i> {!! $file !!}</p>
			                    @endforeach
			                  @endif
			                  
			                  <p class="time">{!! \App\Classes\Helper::showDateTime($response->created_at) !!}</p>
			                </div>
			              </li>
			              @endforeach
			            </ul>
			        </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="box-info">
                    <h2><strong>Ticket</strong> Property</h2>
                	<p><i class="fa fa-hand-o-right"></i> Estimated Response Time
	                    <span class="pull-right span-highlight">
	                      {!! \App\Classes\Helper::showDateTime($ticket->response_due_time) !!}
	                    </span>
	                </p>
	                <p><i class="fa fa-hand-o-right"></i> Estimated Resolution Time
	                    <span class="pull-right span-highlight">
	                      {!! \App\Classes\Helper::showDateTime($ticket->resolution_due_time) !!}
	                    </span>
	                </p>
	                <p><i class="fa fa-hand-o-right"></i> Department
	                    <span class="pull-right span-highlight">{!! ucwords($ticket->Department->department_name) !!}</span>
	                </p>
	                <p><i class="fa fa-hand-o-right"></i> Ticket Type
	                    <span class="pull-right span-highlight">{!! ucwords($ticket->TicketType->ticket_type_name) !!}</span>
	                </p>
	                <p><i class="fa fa-hand-o-right"></i> Ticket Status
	                   <span class="pull-right">{!! \App\Classes\Helper::showTicketStatus($ticket->ticket_status) !!}</span>
	                </p>
	                <p><i class="fa fa-hand-o-right"></i> Ticket Priority
	                   <span class="pull-right">{!! \App\Classes\Helper::showTicketPriority($ticket->ticket_priority) !!}</span>
	                </p>

	                @if($ticket->ticket_status != 'close')
	                <br />
	                <h2><strong>Send</strong> Reply</h2>
          
			          {!! Form::model($ticket,['method' => 'PATCH','route' => ['ticket.response',$ticket->id] ,'class' => 'ticket-form', 'files'=>true]) !!}
			          <div class="form-group">
			            {!! Form::textarea('response_description','',['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Enter Response Content'])!!}
			          </div>
			          <div class="form-group">
			            <input type="file" name="file[]" id="file" class="btn btn-default" title="Select Files" multiple="true">
			          </div>
			          {!! Form::submit(trans('messages.Send'),['class' => 'btn btn-primary']) !!}
			          {!! Form::close() !!}
			        @else
			        	<div class="alert alert-danger">This ticket is now closed. You cannot reply to this ticket.</div>

			        	<a href="/create-ticket" class="btn btn-primary btn-sm"><i class="fa fa-ticket"></i> {!! trans('messages.Create Another Ticket') !!}</a>
			        @endif
                </div>
            </div>
        </div>
    @stop