@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-12">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Edit') !!}</strong> {!! trans('messages.Ticket') !!}
					<div class="additional-btn">
						  <a class="additional-icon" id="dropdownMenu4" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						  </a>
						  <ul class="dropdown-menu pull-right animated half fadeInDown" role="menu" aria-labelledby="dropdownMenu4">
							<li role="presentation"><a role="menuitem" tabindex="-1" href="/ticket/create">{!! trans('messages.Create New Ticket') !!}</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="/ticket">{!! trans('messages.List All Tickets') !!}</a></li>
						  </ul>
					</div>
					</h2>
					
					{!! Form::model($ticket,['method' => 'PATCH','route' => ['ticket.update',$ticket->id] ,'class' => 'ticket-form']) !!}
						@include('ticket._form', ['buttonText' => 'Update'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>

	@stop