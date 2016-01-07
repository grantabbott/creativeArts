@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-8">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Add New') !!} </strong> {!! trans('messages.User') !!}</h2>
					
			        

					<form method="POST" action="/auth/register" accept-charset="UTF-8" class="user-form">
    				  	{!! csrf_field() !!}
						  <div class="form-group">
						    {!! Form::label('name',trans('messages.Name'),['class' => 'control-label'])!!}
							{!! Form::input('text','name','',['class'=>'form-control','placeholder'=>'Enter Name'])!!}
						  </div>
						  <div class="form-group">
						    {!! Form::label('department_id',trans('messages.Department'),['class' => 'control-label'])!!}
							{!! Form::select('department_id', [''=>''] + $departments,'',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Department'])!!}
							<div class="help-box">It is required only for Staff Role.</div>
						  </div>	
						  <div class="form-group">
						    {!! Form::label('role_id',trans('messages.Role'),['class' => 'control-label'])!!}
							{!! Form::select('role_id', [''=>''] + $roles,'',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Role'])!!}
						  </div>	
						  <div class="form-group">
						    {!! Form::label('username',trans('messages.Username'),['class' => 'control-label'])!!}
							{!! Form::input('text','username','',['class'=>'form-control','placeholder'=>'Enter Username'])!!}
							<div class="help-box">It should be unique to every user.</div>
						  </div>
						  <div class="form-group">
						    {!! Form::label('email',trans('messages.Email'),['class' => 'control-label'])!!}
							{!! Form::input('text','email','',['class'=>'form-control','placeholder'=>'Enter Email'])!!}
							<div class="help-box">It should be unique to every user.</div>
						  </div>
						  <div class="form-group">
						    {!! Form::label('password',trans('messages.Password'),['class' => 'control-label'])!!}
							{!! Form::input('password','password','',['class'=>'form-control','placeholder'=>'Enter Password'])!!}
							<div class="help-box">Minimum 6 characters.</div>
						  </div>
						  <div class="form-group">
						    {!! Form::label('password_confirmation',trans('messages.Confirm Password'),['class' => 'control-label'])!!}
							{!! Form::input('password','password_confirmation','',['class'=>'form-control','placeholder'=>'Enter Confirm Password'])!!}
						  </div>
			  				{{ App\Classes\Helper::getCustomFields('user-form',$custom_field_values) }}
				          <div class="form-group">
				            <div class="checkbox">
				            <label>
				              <input type="checkbox" name="send_mail" value="1" checked> Send Mail
				            </label>
				            </div>
				          </div>
						  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Save'),['class' => 'btn btn-primary pull-right']) !!}
					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-sm-4">
				<div class="the-notes info"><h4>{!! trans('messages.Help') !!}</h4>
					In this module, you can add staff or user. User once created will be able to login without any email activation. Keep remember that
					user registered from registration link may or may not require to activate their account by email activation. <br />
					For user role, department id is not necessary. Each role can have customized permission. The permission module can be
					accessed from setting tab.
				</div>
			</div>
		</div>

	@stop