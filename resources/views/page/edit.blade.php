@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-8">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Edit') !!}</strong> {!! trans('messages.Page') !!}
					<div class="additional-btn">
						  <a class="additional-icon" id="dropdownMenu4" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						  </a>
						  <ul class="dropdown-menu pull-right animated half fadeInDown" role="menu" aria-labelledby="dropdownMenu4">
							<li role="presentation"><a role="menuitem" tabindex="-1" href="/page/create">{!! trans('messages.Add New Page') !!}</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="/page">{!! trans('messages.List All Pages') !!}</a></li>
						  </ul>
					</div>
					</h2>
					
					{!! Form::model($page,['method' => 'PATCH','route' => ['page.update',$page->id] ,'class' => 'page-form']) !!}
						@include('page._form', ['buttonText' => 'Update Page'])
					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-sm-4">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Help') !!}</strong></h2> If you want to update any information published in a notice, then you can simply go to list notice and then click on the edit button of that notice. You can update
					all the information provided in the form. Once updated, it will be reflected to all the desired users's dashboard.</h2>
				</div>
			</div>
		</div>

	@stop