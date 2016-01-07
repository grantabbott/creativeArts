@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-8">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Add New') !!}</strong> {!! trans('messages.Ticket') !!}
					<div class="additional-btn">
						  <a class="additional-icon" id="dropdownMenu4" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						  </a>
						  <ul class="dropdown-menu pull-right animated half fadeInDown" role="menu" aria-labelledby="dropdownMenu4">
							<li role="presentation"><a role="menuitem" tabindex="-1" href="/ticket">{!! trans('messages.List All Tickets') !!}</a></li>
						  </ul>
					</div>
					</h2>
					
					{!! Form::open(['route' => 'ticket.store','role' => 'form', 'class'=>'ticket-form']) !!}
						@include('ticket._form')
					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-sm-4">
				<div class="the-notes info"><h4>{!! trans('messages.Help') !!}</h4>
				Tickets are issued reported by the users. It can be well managed if more details like department the issue is related,
				type of issue, priority of issue etc are available. This module helps to track the issues and its resolution. Staff can
				edit/reply to the ticket. Once a ticket is generated, estimated response time & resolution time is set as per the business hour
				and service time set in the configuration module. This response time & resolution time is visible to the client and admin so that
				it can be tracked accordingly.
				</div>
			</div>
		</div>

	@stop