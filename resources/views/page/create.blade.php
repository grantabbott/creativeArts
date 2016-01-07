@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-8">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Add New') !!}</strong> {!! trans('messages.Page') !!}
					<div class="additional-btn">
						  <a class="additional-icon" id="dropdownMenu4" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						  </a>
						  <ul class="dropdown-menu pull-right animated half fadeInDown" role="menu" aria-labelledby="dropdownMenu4">
							<li role="presentation"><a role="menuitem" tabindex="-1" href="/page">{!! trans('messages.List All Pages') !!}</a></li>
						  </ul>
					</div>
					</h2>
					
					{!! Form::open(['route' => 'page.store','role' => 'form', 'class'=>'page-form']) !!}
						@include('page._form')
					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-sm-4">
				<div class="the-notes info"><h4>{!! trans('messages.Help') !!}</h4>
				Pages are custom page designed by organization to display in this suport system. Every page designed and published here will generate a
				link in the home page of this support system. User once clicked on that link, the page description is visible. Admin can choose
				which page can be accessed by sign-in user or by all user by selecting the check box.</div>
			</div>
		</div>

	@stop