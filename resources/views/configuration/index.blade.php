@extends('layouts.default')

	@section('content')

		<div class="row">
			<div class="col-sm-12">
				<div class="box-info">

					<div class="tabs-left row">	
						<ul class="nav nav-tabs col-md-2" style="padding-right:0;">
						  <li class="active"><a href="#general" data-toggle="tab"><span class="fa fa-cog"></span> {!! trans('messages.General') !!}</a></li>
						  <li><a href="#system" data-toggle="tab"><span class="fa fa-wrench"></span> {!! trans('messages.System') !!}</a></li>
						  <li><a href="#social_login" data-toggle="tab"><span class="fa fa-sign-in"></span> {!! trans('messages.Social Login') !!}</a></li>
						  <li><a href="#permission" data-toggle="tab"><span class="fa fa-key"></span> {!! trans('messages.Permission') !!}</a></li>
						  <li><a href="#mail" data-toggle="tab"><span class="fa fa-envelope"></span> {!! trans('messages.Mail') !!}</a></li>
						  <li><a href="#department" data-toggle="tab"><span class="fa fa-sitemap"></span> {!! trans('messages.Department') !!}</a></li>
						  <li><a href="#ticket" data-toggle="tab"><span class="fa fa-ticket"></span> {!! trans('messages.Ticket') !!}</a></li>
						  <li><a href="#business_hour" data-toggle="tab"><span class="fa fa-calendar"></span> {!! trans('messages.Business Hour') !!}</a></li>
						  <li><a href="#service_time" data-toggle="tab"><span class="fa fa-clock-o"></span> {!! trans('messages.Service Time') !!}</a></li>
				        </ul>
				        <div id="myTabContent" class="tab-content col-md-9">
				        
						  <div class="tab-pane animated active fadeInRight" id="general">
						    <div class="user-profile-content-wm">
								<h2><strong>{!! trans('messages.General') !!}</strong> {!! trans('messages.Configuration') !!}</h2>
								{!! Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-form ']) !!}
									@include('configuration._form')
								{!! Form::close() !!}
							</div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="system">
						    <div class="user-profile-content-wm">
								<h2><strong>{!! trans('messages.System') !!}</strong> {!! trans('messages.Configuration') !!}</h2>
								{!! Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-form ']) !!}
									@include('configuration._system_form')
								{!! Form::close() !!}
							</div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="mail">
						    <div class="user-profile-content">
								<h2><strong>{!! trans('messages.Mail') !!}</strong> {!! trans('messages.Configuration') !!}</h2>
								{!! Form::open(['route' => 'configuration.mailStore','role' => 'form', 'class'=>'mail-form ']) !!}
									@include('configuration._mail')
								{!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="permission">
						    <div class="user-profile-content">
								
								<div class="col-sm-4">
									<div class="box-info">
										<h2><strong>Create New Role</strong> </h2>
										{!! Form::open(['route' => 'role.store','role' => 'form', 'class'=>'role-form']) !!}
											@include('role._form')
										{!! Form::close() !!}
									</div>
								</div>
								<div class="col-sm-8">
									<div class="box-info">
										<h2><strong>List All Role</strong> </h2>
										<div class="table-responsive">
											<table class="table table-hover table-striped">
												<thead>
													<tr>
														<th>{!! trans('messages.Name') !!}</th>
														<th>{!! trans('messages.Display Name') !!}</th>
														<th>{!! trans('messages.Option') !!}</th>
													</tr>
												</thead>
												<tbody>
													@foreach($roles as $role)
														<tr>
															<td>{!! $role->name !!}</td>
															<td>{!! $role->display_name !!}</td>
															<td>
																<a href="{!! URL::to('/role/'.$role->id.'/edit') !!}" class='btn btn-xs btn-default' data-toggle='modal' data-target='#myModal' > <i class='fa fa-edit'></i> Edit</a>
																{!! delete_form(['role.destroy',$role->id]) !!}
															</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="clear"></div>

								<h2><strong>{!! trans('messages.Manage') !!}</strong> {!! trans('messages.Permission') !!}</h2>
								{!! Form::open(['route' => 'configuration.save_permission','role' => 'form', 'class'=>'permission-form ']) !!}
								  <table class="table table-hover table-striped">
								  	<thead>
								  		<tr>
								  			<th>Permission</th>
								  			@foreach($roles as $role)
								  			<th>{!! ucwords($role->name) !!}</th>
								  			@endforeach
								  		</tr>
								  		</tr>
								  	</thead>
								  	<tbody>
								  		@foreach($permissions as $permission)
								  			@if($permission->category != $category)
								  			<tr style="background-color:#3498DB;color:#ffffff;"><td colspan="{!! count($roles)+1 !!} "><strong>{!! \App\Classes\Helper::toWord($permission->category) !!} Module</strong></td></tr>
								  			<?php $category = $permission->category; ?>
								  			@endif
								  			<tr>
								  				<td>{!! ucwords($permission->display_name) !!}</td>
									  			@foreach($roles as $role)
									  			<th><input type="checkbox" name="permission[{!!$role->id!!}][{!!$permission->id!!}]" value = '1' {!! (in_array($role->id.'-'.$permission->id,$permission_role)) ? 'checked' : '' !!}></th>
									  			@endforeach
								  			</tr>
								  		@endforeach
								  	</tbody>
								  </table>
								  <br /><br />
								  {!! Form::submit(isset($buttonText) ? $buttonText : 'Save Permission',['class' => 'btn btn-primary pull-right']) !!}
								{!! Form::close() !!}
								<div class="clear"></div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="ticket">
						    <div class="user-profile-content">
								<div class="row">
									<div class="col-sm-6">
										<div class="box-info">
											<h2><strong>{!! trans('messages.Add New') !!}</strong> {!! trans('messages.Ticket Type') !!}</h2>
											{!! Form::open(['route' => 'ticket_type.store','role' => 'form', 'class'=>'ticket-type-form ']) !!}
												@include('ticket_type._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-6">
										<div class="box-info">
											<h2><strong>{!! trans('messages.List All') !!}</strong> {!! trans('messages.Ticket Types') !!}</h2>
												<div class="table-responsive">
													<table class="table table-hover table-striped">
														<thead>
															<tr>
																<th>{!! trans('messages.Ticket Type') !!}</th>
																<th>{!! trans('messages.Option') !!}</th>
															</tr>
														</thead>
														<tbody>
															@foreach($ticket_types as $ticket_type)
																<tr>
																	<td>{!! $ticket_type->ticket_type_name !!}</td>
																	<td>
																		<a href="{!! URL::to('/ticket_type/'.$ticket_type->id.'/edit') !!}" class='btn btn-xs btn-default' data-toggle='modal' data-target='#myModal' > <i class='fa fa-edit'></i> Edit</a>
																		{!! delete_form(['ticket_type.destroy',$ticket_type->id]) !!}
																	</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12">
										<div class="box-info">
											<h2><strong>Other Ticket Setting</strong></h2>
											{!! Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'ticket-type-form ']) !!}
												<div class="col-sm-6">
													<div class="form-group">
												    	{!! Form::label('new_ticket_send_mail',trans('messages.Send Mail on new Ticket'),[])!!}
													    <div class="radio">
															<label>
																{!! Form::radio('new_ticket_send_mail', 1, (config('config.new_ticket_send_mail')) ? 'checked' : '') !!} Yes
															</label>
															<label>
																{!! Form::radio('new_ticket_send_mail', 0, (!config('config.new_ticket_send_mail')) ? 'checked' : '') !!} No
															</label>
														</div>
												  	</div>
												  	<div class="form-group">
												    	{!! Form::label('next_ticket_no',trans('messages.Next Ticket No'),[])!!}
														{!! Form::input('number','next_ticket_no',$next_ticket_no,['class'=>'form-control','placeholder'=>'Enter Next Ticket Number'])!!}
												  	</div>
												  	<div class="form-group">
												    	{!! Form::label('max_file_upload_at_once',trans('messages.Max Files Upload at once'),[])!!}
														{!! Form::input('number','max_file_upload_at_once',config('config.max_file_upload_at_once'),['class'=>'form-control','placeholder'=>'Enter Maximum files that can be uploaded at once'])!!}
												  	</div>
												{!! Form::hidden('config_type','ticket')!!}
			  									{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Save'),['class' => 'btn btn-primary']) !!}
												</div>
											{!! Form::close() !!}
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="department">
						    <div class="user-profile-content">
								<div class="row">
									<div class="col-sm-6">
										<div class="box-info">
											<h2><strong>{!! trans('messages.Add New') !!}</strong> {!! trans('messages.Department') !!}</h2>
											{!! Form::open(['route' => 'department.store','role' => 'form', 'class'=>'department-form ']) !!}
												@include('department._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-6">
										<div class="box-info">
											<h2><strong>{!! trans('messages.List All') !!}</strong> {!! trans('messages.Departments') !!}</h2>
												<div class="table-responsive">
													<table class="table table-hover table-striped">
														<thead>
															<tr>
																<th>{!! trans('messages.Department Name') !!}</th>
																<th>{!! trans('messages.Option') !!}</th>
															</tr>
														</thead>
														<tbody>
															@foreach($departments as $department)
																<tr>
																	<td>{!! $department->department_name !!}</td>
																	<td>
																		<a href="{!! URL::to('/department/'.$department->id.'/edit') !!}" class='btn btn-xs btn-default' data-toggle='modal' data-target='#myModal' > <i class='fa fa-edit'></i> Edit</a>
																		{!! delete_form(['department.destroy',$department->id]) !!}
																	</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="business_hour">
						    <div class="user-profile-content">
								<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong>{!! trans('messages.Add New') !!}</strong> {!! trans('messages.Business Hour') !!}</h2>
											{!! Form::open(['route' => 'business_hour.store','role' => 'form', 'class'=>'business-hour-form ']) !!}
												@include('business_hour._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info">
											<h2><strong>{!! trans('messages.List All') !!}</strong> {!! trans('messages.Business Hour') !!}</h2>
												<div class="table-responsive">
													<table class="table table-hover table-striped">
														<thead>
															<tr>
																<th>{!! trans('messages.Day') !!}</th>
																<th>{!! trans('messages.Start') !!}</th>
																<th>{!! trans('messages.End') !!}</th>
																<th>{!! trans('messages.Option') !!}</th>
															</tr>
														</thead>
														<tbody>
															@foreach($business_hours as $business_hour)
																<tr>
																	<td>{!! $business_hour->day !!}</td>
																	<td>{!! \App\Classes\Helper::showTime($business_hour->start) !!}</td>
																	<td>{!! \App\Classes\Helper::showTime($business_hour->end) !!}</td>
																	<td>
																		<a href="{!! URL::to('/business_hour/'.$business_hour->id.'/edit') !!}" class='btn btn-xs btn-default' data-toggle='modal' data-target='#myModal' > <i class='fa fa-edit'></i> Edit</a>
																		{!! delete_form(['business_hour.destroy',$business_hour->id]) !!}
																	</td>
															@endforeach
														</tbody>
													</table>
												</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="service_time">
						    <div class="user-profile-content">
								<div class="row">
									<div class="col-sm-12">
										<div class="box-info">
											<h2><strong>{!! trans('messages.Add New') !!}</strong> {!! trans('messages.Service Time') !!}</h2>
											{!! Form::open(['route' => 'service_time.store','role' => 'form', 'class'=>'service-time-form ']) !!}
												@include('service_time._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-12">
										<div class="box-info">
											<h2><strong>{!! trans('messages.List All') !!}</strong> {!! trans('messages.Service Time') !!}</h2>
												<div class="table-responsive">
													<table class="table table-hover table-striped">
														<thead>
															<tr>
																<th>{!! trans('messages.Priority') !!}</th>
																<th>{!! trans('messages.Response Time') !!}</th>
																<th>{!! trans('messages.Resolution Time') !!}</th>
																<th>{!! trans('messages.Option') !!}</th>
															</tr>
														</thead>
														<tbody>
															@foreach($service_times as $service_time)
																<tr>
																	<td>{!! ucfirst($service_time->priority) !!}</td>
																	<td>{!! $service_time->response_time.' '.ucfirst($service_time->response_unit).' ('.\App\Classes\Helper::toWord($service_time->response_time_type).')' !!}</td>
																	<td>{!! $service_time->resolution_time.' '.ucfirst($service_time->resolution_unit).' ('.\App\Classes\Helper::toWord($service_time->resolution_time_type).')'  !!}</td>
																	<td>
																		<a href="{!! URL::to('/service_time/'.$service_time->id.'/edit') !!}" class='btn btn-xs btn-default' data-toggle='modal' data-target='#myModal' > <i class='fa fa-edit'></i> Edit</a>
																		{!! delete_form(['service_time.destroy',$service_time->id]) !!}
																	</td>
															@endforeach
														</tbody>
													</table>
												</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="social_login">
						    <div class="user-profile-content">
								<div class="row">
									<div class="col-sm-12">
										{!! Form::open(['route' => 'configuration.socialLoginStore','role' => 'form', 'class'=>'social-login-form form-horizontal']) !!}
											@include('configuration._social_login')
										{!! Form::hidden('config_type','social_login')!!}
										{!! Form::close() !!}
									</div>
								</div>
						    </div>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	<script>
	</script>		
	@stop