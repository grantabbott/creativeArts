@extends('layouts.default')

	@section('content')
		<div class="row">
			<div class="col-sm-12">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Edit') !!} </strong> {!! trans('messages.User') !!}</h2>
					
					{!! Form::model($user,['method' => 'PATCH','route' => ['user.update',$user->id] ,'class' => 'user-form']) !!}
						  <div class="form-group">
						    {!! Form::label('name',trans('messages.Name'),['class' => 'control-label'])!!}
							{!! Form::input('text','name',isset($user->name) ? $user->name : '',['class'=>'form-control','placeholder'=>'Enter Name'])!!}
						  </div>
						  <div class="form-group">
						    {!! Form::label('department_id',trans('messages.Department'),['class' => 'control-label'])!!}
							{!! Form::select('department_id', [''=>''] + $departments,isset($user->Profile->department_id) ? $user->Profile->department_id : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Department'])!!}
						  </div>	
						  <div class="form-group">
						    {!! Form::label('role_id',trans('messages.Role'),['class' => 'control-label'])!!}
							{!! Form::select('role_id', [''=>''] + $roles, isset($role_id) ? $role_id : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Role'])!!}
						  </div>
						  <div class="form-group">
						    {!! Form::label('email',trans('messages.Email'),['class' => 'control-label'])!!}
							{!! Form::input('text','email',isset($user->email) ? $user->email : '',['class'=>'form-control','placeholder'=>'Enter Email'])!!}
						  </div>
			  				{{ App\Classes\Helper::getCustomFields('user-form',$custom_field_values) }}
						  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Save'),['class' => 'btn btn-primary']) !!}
					{!! Form::close() !!}
				</div>
			</div>
		</div>

	@stop