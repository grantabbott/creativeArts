
			  <div class="form-group">
			    {!! Form::label('priority',trans('messages.Priority'),['class' => 'control-label'])!!}
			    {!! Form::select('priority', [null=>'Select One'] + $priority
			    	, isset($service_time->priority) ? $service_time->priority : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Priority'])!!}
			  </div>
			  <div class="form-inline">
			  	<div class="form-group">
			    {!! Form::input('text','response_time',isset($service_time->response_time) ? $service_time->response_time : '',['class'=>'form-control','placeholder'=>'Enter Response Time'])!!}
			    </div>
			  	<div class="form-group">
			  	{!! Form::select('response_unit', [null=>'Response Time Unit'] + $time_unit
			    	, isset($service_time->response_unit) ? $service_time->response_unit : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Unit'])!!}
			    </div>
			  	<div class="form-group">
			  	{!! Form::select('response_time_type', [null=>'Response Time Type'] + $time_type
			    	, isset($service_time->response_time_type) ? $service_time->response_time_type : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Type'])!!}
			    </div>
			  </div>
			  <br />
			  <div class="form-inline">
			  	<div class="form-group">
			    {!! Form::input('text','resolution_time',isset($service_time->resolution_time) ? $service_time->resolution_time : '',['class'=>'form-control','placeholder'=>'Enter Resolution Time'])!!}
			    </div>
			  	<div class="form-group">
			  	{!! Form::select('resolution_unit', [null=>'Resolution Time Unit'] + $time_unit
			    	, isset($service_time->resolution_unit) ? $service_time->resolution_unit : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Unit'])!!}
			    </div>
			  	<div class="form-group">
			  	{!! Form::select('resolution_time_type', [null=>'Resolution Time Type'] + $time_type
			    	, isset($service_time->resolution_time_type) ? $service_time->resolution_time_type : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Type'])!!}
			    </div>
			  </div>
			  <br />
			  {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Add'),['class' => 'btn btn-primary']) !!}