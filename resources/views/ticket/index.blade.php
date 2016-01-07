@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-12">
				<div class="box-info">
					<h2><strong>Filter</strong></h2>
					{!! Form::open(['route' => 'ticket.index','role' => 'form', 'class'=>'ticket-filter-form']) !!}
						<div class="col-md-3">
							<div class="form-group">
							 {!! Form::label('start_date',trans('messages.From Date'),['class' => 'control-label'])!!}
							 {!! Form::input('text','start_date',($filter_data['start_date']) ? : '',['class'=>'form-control datepicker-input','placeholder'=>'Enter Start Date','readonly' => 'true'])!!}
							</div>
							<div class="form-group">
							 {!! Form::label('end_date',trans('messages.To Date'),['class' => 'control-label'])!!}
							 {!! Form::input('text','end_date',($filter_data['end_date']) ? : '',['class'=>'form-control datepicker-input','placeholder'=>'Enter End Date','readonly' => 'true'])!!}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							    {!! Form::label('department_id',trans('messages.Department'),['class' => 'control-label'])!!}
							    {!! Form::select('department_id', [null=>'Select One'] + $departments
							    	, ($filter_data['department_id']) ? : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Department'])!!}
							</div>
							<div class="form-group">
							    {!! Form::label('ticket_type_id',trans('messages.Type'),['class' => 'control-label'])!!}
							    {!! Form::select('ticket_type_id', [null=>'Select One'] + $ticket_types
							    	, ($filter_data['ticket_type_id']) ? : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Type'])!!}
							</div>
							@if(Entrust::hasRole('admin'))
							<div class="form-group">
							    {!! Form::label('assigned',trans('messages.Assign/Unassign'),['class' => 'control-label'])!!}
							    {!! Form::select('assigned', [null=>'Select One','assigned' => 'Assigned', 'unassigned' => 'Un-assigned']
							    	, ($filter_data['assigned']) ? : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select One'])!!}
							</div>
							@endif
						</div>
						<div class="col-md-3">
							<div class="form-group">
							    {!! Form::label('ticket_priority',trans('messages.Priority'),['class' => 'control-label'])!!}
							    {!! Form::select('ticket_priority', [null=>'Select One'] + config('list.priority')
							    	, ($filter_data['ticket_priority']) ? : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Priority'])!!}
							</div>
							<div class="form-group">
							    {!! Form::label('ticket_status',trans('messages.Status'),['class' => 'control-label'])!!}
							    {!! Form::select('ticket_status', [null=>'Select One'] + config('list.ticket_status')
							    	, ($filter_data['ticket_status']) ? : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Status'])!!}
							</div>
							@if(Entrust::hasRole('admin'))
							<div class="form-group">
	                          {!! Form::label('user_id',trans('messages.Staff'),['class' => 'control-label'])!!}
	                          {!! Form::select('user_id[]', $users, ($filter_data['user_id']) ? : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select User','multiple' => true])!!}
	                        </div>
							@endif
						</div>
						<div class="col-md-3">
						  <div class="form-group">
							{!! Form::label('response_time_overdue',trans('messages.Response Time Overdue'),[])!!}
							  <div class="checkbox">
								<label>
								  <input type="checkbox" name="response_time_overdue" value="1" {!! ($filter_data['response_time_overdue']) ? 'checked' : '' !!}> Response Time Overdue
								</label>
							  </div>
						  </div>
						  <div class="form-group">
							{!! Form::label('resolution_time_overdue',trans('messages.Resolution Time Overdue'),[])!!}
							  <div class="checkbox">
								<label>
								  <input type="checkbox" name="resolution_time_overdue" value="1" {!! ($filter_data['resolution_time_overdue']) ? 'checked' : '' !!} > Resolution Time Overdue
								</label>
							  </div>
						  </div>
						{!! Form::submit(trans('messages.Filter'),['class' => 'btn btn-primary']) !!}
						</div>
					{!! Form::close() !!}
				</div>
				<div class="box-info">
					<h2><strong>{!! trans('messages.List All') !!}</strong> {!! trans('messages.Tickets') !!}
					<div class="additional-btn">
						  <a class="additional-icon" id="dropdownMenu4" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						  </a>
						  <ul class="dropdown-menu pull-right animated half fadeInDown" role="menu" aria-labelledby="dropdownMenu4">
							<li role="presentation"><a role="menuitem" tabindex="-1" href="/ticket/create">{!! trans('messages.Create New Ticket') !!}</a></li>
						  </ul>
					</div>
					</h2>
					@include('common.datatable',['col_heads' => $col_heads])
				</div>
			</div>
		</div>

	@stop