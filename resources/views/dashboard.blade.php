@extends('layouts.default')

	@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="box-info animated fadeInDown">
				<h2><strong>Ticket</strong> Statistics Between {!! \App\Classes\Helper::showDate($start_date).' to '.\App\Classes\Helper::showDate($end_date) !!}
					<div class="additional-box">
						<form role="form" class="form-inline" action="/dashboard" method="post">
							{!! csrf_field() !!}
							{!! Form::input('text','start_date',isset($start_date) ? $start_date : '',['class'=>'form-control datepicker-input','placeholder'=>'Enter Start Date','readonly' => 'true'])!!}
							{!! Form::input('text','end_date',isset($end_date) ? $end_date : '',['class'=>'form-control datepicker-input','placeholder'=>'Enter End Date','readonly' => 'true'])!!}
							<button type="submit" class="btn btn-primary">Filter</button>
						</form>
					</div>
				</h2>
				<div class="col-md-3">
					<h5>By Status</h5>
					<div id="ticket-status-stat" style="height: 250px;"></div>
				</div>
				<div class="col-md-3">
					<h5>By Priority</h5>
					<div id="ticket-priority-stat" style="height: 250px;"></div>
				</div>
				<div class="col-md-3">
					<h5>By Ticket Type</h5>
					<div id="ticket-type-stat" style="height: 250px;"></div>
				</div>
				<div class="col-md-3">
					<h5>By Department</h5>
					<div id="ticket-department-stat" style="height: 250px;"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 col-xs-6">
			<div class="box-info">
				<div class="icon-box">
					<span class="fa-stack">
					  <i class="fa fa-circle fa-stack-2x info"></i>
					  <i class="fa fa-users fa-stack-1x fa-inverse"></i>
					</span>
				</div>
				<div class="text-box">
					<h3>{!! $user_count !!}</h3>
					<p>Registered User</p>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="col-sm-3 col-xs-6">
			<div class="box-info">
				<div class="icon-box">
					<span class="fa-stack">
					  <i class="fa fa-circle fa-stack-2x warning"></i>
					  <i class="fa fa-user fa-stack-1x fa-inverse"></i>
					</span>
				</div>
				<div class="text-box">
					<h3>{!! $staff_count !!}</h3>
					<p>Total Staff</p>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="col-sm-3 col-xs-6">
			<div class="box-info">
				<div class="icon-box">
					<span class="fa-stack">
					  <i class="fa fa-circle fa-stack-2x success"></i>
					  <i class="fa fa-ticket fa-stack-1x fa-inverse"></i>
					</span>
				</div>
				<div class="text-box">
					<h3>{!! $ticket_count !!}</h3>
					<p>Total Ticket Generated</p>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="col-sm-3 col-xs-6">
			<div class="box-info">
				<div class="icon-box">
					<span class="fa-stack">
					  <i class="fa fa-circle fa-stack-2x danger"></i>
					  <i class="fa fa-tasks fa-stack-1x fa-inverse"></i>
					</span>
				</div>
				<div class="text-box">
					<h3>{!! $closed_ticket_percentage !!} %</h3>
					<p>Ticket Closed</p>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="box-info">
				<div id="calendar"></div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="box-info">
				<h2><strong>{!! trans('messages.Recent') !!}</strong> {!! trans('messages.Activity') !!}</h2>
				<div class="scroll-widget">
					<ul class="media-list">
					@foreach($activities as $activity)
					  <li class="media">
						<a class="pull-{!! App\Classes\Helper::activityShow() !!}" href="#fakelink">
						  {!! App\Classes\Helper::getAvatar($activity->user_id) !!}
						</a>
						<div class="media-body {!! App\Classes\Helper::activityColorShow() !!}">
						  <strong>@if(Auth::user()->id == $activity->user_id) Me @else {!! $activity->name !!} @endif</strong><br />
						  {!! $activity->text !!}
						  <p class="time">{!! App\Classes\Helper::showDateTime($activity->created_at) !!}</p>
						</div>
					  </li>
					@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="box-info">
				<h2><strong>{!! trans('messages.Quick') !!}</strong> {!! trans('messages.Message') !!}</h2>
				<div class="additional-btn">
					  <a class="additional-icon" id="dropdownMenu5" data-toggle="dropdown">
						<i class="fa fa-cog"></i>
					  </a>
					  <ul class="dropdown-menu pull-right flip animated half fadeInDown" role="menu" aria-labelledby="dropdownMenu5">
						<li role="presentation"><a role="menuitem" tabindex="-1" href="/message/compose">{!! trans('messages.Compose') !!}</a></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="/message">{!! trans('messages.Go to Inbox') !!}</a></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="/message/sent">{!! trans('messages.Go to Sent Folder') !!}</a></li>
					  </ul>
					  <a class="additional-icon" href="#" data-toggle="collapse" data-target="#quick-post"><i class="fa fa-chevron-down"></i></a>
				</div>
				
				<div id="quick-post" class="collapse in">
					{!! Form::open(['route' => 'message.store','role' => 'form', 'class'=>'compose-form']) !!}
						<div class="form-group">
							{!! Form::select('to_user_id', [null=>'Please select'] + $user_list, '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Staff'])!!}
						</div>
						<div class="form-group">
							{!! Form::input('text','subject','',['class'=>'form-control','placeholder'=>'Message subject'])!!}
						</div>
						<div class="form-group">
							{!! Form::textarea('content','',['class' => 'form-control summernote-small', 'placeholder' => 'Enter Description'])!!}
						</div>
						<div class="row">
							<div class="col-md-6">
								<button type="submit" class="btn btn-sm btn-success">{!! trans('messages.Send') !!}</button>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
	@stop