@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-12">
				<div class="box-info">
					<h2><strong>{!! trans('messages.List All') !!}</strong> {!! trans('messages.Users') !!}</h2>
					@include('common.datatable',['col_heads' => $col_heads])
				</div>
			</div>
		</div>

	@stop