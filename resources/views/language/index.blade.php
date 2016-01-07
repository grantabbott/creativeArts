@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-3">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Add New') !!}</strong> {!! trans('messages.Language') !!}</h2>
					{!! Form::open(['route' => 'language.store','role' => 'form', 'class'=>'language-form']) !!}
						@include('language._form')
					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-sm-9">
				<div class="box-info">
					<h2><strong>{!! trans('messages.List All') !!}</strong> {!! trans('messages.Languages') !!}</h2>
					@include('common.datatable',['col_heads' => $col_heads])
				</div>
			</div>

		</div>

	@stop