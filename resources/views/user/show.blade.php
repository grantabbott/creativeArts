	@extends('layouts.full')
	
	@section('content')
		<div class="row">
			<div class="col-sm-3">
				<!-- Begin user profile -->
				<div class="box-info ">
					@include('auth.user_detail',['user' => $user, 'name' => 1, 'email' => 1,'role' => 1])
				</div><!-- End div .box-info -->

				@if(Entrust::can('reset_user_password'))
				<div class="box-info">
					<h4>Reset Password</h4>
					{!! Form::model($user,['method' => 'PATCH','route' => ['change_user_password',$user->id] ,'class' => 'change-user-password-form']) !!}
					  <div class="form-group">
						{!! Form::input('password','new_password','',['class'=>'form-control','placeholder'=>'Enter New Password'])!!}
					  </div>
					  <div class="form-group">
						{!! Form::input('password','new_password_confirmation','',['class'=>'form-control','placeholder'=>'Enter New Confirm Password'])!!}
					  </div>
					  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Save'),['class' => 'btn btn-primary']) !!}
					{!! Form::close() !!}
				</div>
				@endif
				<!-- Begin user profile -->
			</div><!-- End div .col-sm-4 -->
			
			<div class="col-sm-9">
				<div class="box-info">
					<h2><strong>{!! trans('messages.Basic Information') !!}</strong></h2>
					
							
						{!! Form::model($user,['files' => true, 'method' => 'PATCH','action' => ['UserController@profileUpdate',$user->id] ,'class' => 'user-profile-update-form', 'role' => 'form']) !!}
	    				  	<div class="col-sm-6">
		    				  	<div class="form-group">
								    {!! Form::label('contact_number',trans('messages.Contact Number'))!!}
									{!! Form::input('text','contact_number',isset($profile->contact_number) ? $profile->contact_number : '',['class'=>'form-control','placeholder'=>'Enter Contact Number'])!!}
								</div>
								<div class="form-group">
								    {!! Form::label('alternate_contact_number',trans('messages.Alternate Contact Number'))!!}
									{!! Form::input('text','alternate_contact_number',isset($profile->alternate_contact_number) ? $profile->alternate_contact_number : '',['class'=>'form-control','placeholder'=>'Enter Alternate Contact Number'])!!}
								</div>
								<div class="form-group">
								    {!! Form::label('alternate_email',trans('messages.Alternate Email'))!!}
									{!! Form::input('email','alternate_email',isset($profile->alternate_email) ? $profile->alternate_email : '',['class'=>'form-control','placeholder'=>'Enter Alternate Email'])!!}
								</div>
								<div class="form-group">
								    {!! Form::label('address',trans('messages.Address'),[])!!}
								    {!! Form::textarea('address',isset($profile->address) ? $profile->address : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => 'Enter Address'])!!}
								</div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
							    {!! Form::label('timezone_id',trans('messages.Timezone'),[])!!}
								{!! Form::select('timezone_id', [null=>'Please Select'] + config('timezone'),isset($profile->timezone_id) ? $profile->timezone_id : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Timezone'])!!}
							  </div>
		    				  	<div class="form-group">
									<input type="file" name="photo" id="photo" class="btn btn-default" title="Select Profile Photo">
									@if($profile->photo != null)
										<div class="checkbox">
											<label>
											  {!! Form::checkbox('remove_photo', 1) !!} {!! trans('messages.Remove Photo') !!}
											</label>
										</div>
									@endif
								</div>
							{{ App\Classes\Helper::getCustomFields('user-form',$custom_field_values) }}
							{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Save'),['class' => 'btn btn-primary']) !!}
							</div>
						{!! Form::close() !!}
						
				</div><!-- End div .box-info -->
			</div>
		</div>
				
	@stop