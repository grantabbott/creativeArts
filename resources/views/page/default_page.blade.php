@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-8">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Default Pages') !!}</strong></h2>
					
					{!! Form::open(['route' => 'defaultPage','role' => 'form', 'class'=>'default-page-form']) !!}
						
					  <div class="form-group">
					    {!! Form::label('homepage_title','Homepage Title',[])!!}
						{!! Form::input('text','homepage_title',config('page.homepage.title'),['class'=>'form-control','placeholder'=>'Enter Title'])!!}
					  </div>
					  <div class="form-group">
					    {!! Form::label('homepage','Homepage',[])!!}
					    {!! Form::textarea('homepage',config('page.homepage.description'),['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Enter Content'])!!}
					  </div>
					  <div class="form-group">
					    {!! Form::label('business_hour_title','Business Hour Title',[])!!}
						{!! Form::input('text','business_hour_title',config('page.business_hour.title'),['class'=>'form-control','placeholder'=>'Enter Title'])!!}
					  </div>
					  <div class="form-group">
					    {!! Form::label('business_hour','Business Hour',[])!!}
					    {!! Form::textarea('business_hour',config('page.business_hour.description'),['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Enter Content'])!!}
					  </div>
					  <div class="form-group">
					    {!! Form::label('terms_and_conditions_title','Terms & Conditions Title',[])!!}
						{!! Form::input('text','terms_and_conditions_title',config('page.terms_and_conditions.title'),['class'=>'form-control','placeholder'=>'Enter Title'])!!}
					  </div>
					  <div class="form-group">
					    {!! Form::label('terms_and_conditions','Terms & Conditions',[])!!}
					    {!! Form::textarea('terms_and_conditions',config('page.terms_and_conditions.description'),['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Enter Content'])!!}
					  </div>
					  	{!! Form::submit(trans('messages.Save'),['class' => 'btn btn-primary']) !!}

					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-sm-4">
				<div class="the-notes info"><h4>{!! trans('messages.Help') !!}</h4>
				Link of default pages will be displayed under homepage. You can set the content of default pages accordingly.</div>
			</div>
		</div>

	@stop