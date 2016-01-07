@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-8">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Add New') !!}</strong> {!! trans('messages.Annoucement') !!}
					<div class="additional-btn">
						  <a class="additional-icon" id="dropdownMenu4" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						  </a>
						  <ul class="dropdown-menu pull-right animated half fadeInDown" role="menu" aria-labelledby="dropdownMenu4">
							<li role="presentation"><a role="menuitem" tabindex="-1" href="/annoucement">{!! trans('messages.List All Annoucements') !!}</a></li>
						  </ul>
					</div>
					</h2>
					{!! Form::open(['route' => 'annoucement.store','role' => 'form', 'class'=>'annoucement-form']) !!}
						@include('annoucement._form')
					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-sm-4">
				<div class="the-notes info"><h4>{!! trans('messages.Help') !!}</h4>
				Annoucements are public/private notices used to circulate information inside/outside your organization. Every annoucement here must have a
				start date and end date. These are the dates between which the annoucement will be visible to desired audience. Annoucement
				can be made visible to selected role. If role is kept blank then it will be public.</div>
			</div>
		</div>

	@stop