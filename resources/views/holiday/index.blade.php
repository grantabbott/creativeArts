@extends('layouts.default')

	@section('content')
		<div class="row">
			@if(Entrust::can('create_holiday'))
			<div class="col-sm-4">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Add New') !!}</strong></h2>
					{!! Form::open(['route' => 'holiday.store','role' => 'form', 'class'=>'holiday-form']) !!}
						@include('holiday._form')
					{!! Form::close() !!}
				</div>
			</div>
			@endif
			<div class="col-sm-8">
				<div class="box-info">
					<h2><strong>{!! trans('messages.List All') !!}</strong> {!! trans('messages.Holidays') !!}</h2>
					@include('common.datatable',['col_heads' => $col_heads])
				</div>
			</div>

		</div>

	@stop