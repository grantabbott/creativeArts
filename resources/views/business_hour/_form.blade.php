
			  <div class="form-group">
			    {!! Form::label('day',trans('messages.Day'),['class' => 'control-label'])!!}
			    {!! Form::select('day', [null=>'Select One'] + $week_days
			    	, isset($business_hour->day) ? $business_hour->day : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Day'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('start',trans('messages.Start Time'),[])!!}
				<div class="input-group date timepicker" data-date="" data-date-format="hh:ii" data-link-field="start" data-link-format="hh:ii">
                    <input class="form-control" size="16" type="text" value="{!! isset($business_hour->start) ? date('H:i',strtotime($business_hour->start)) : '' !!}" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
				<input type="hidden" name="start" id="start" value="{!! isset($business_hour->start) ? date('H:i',strtotime($business_hour->start)) : '' !!}" /><br/>
			  </div>
			  <div class="form-group">
			    {!! Form::label('end',trans('messages.End Time'),[])!!}
				<div class="input-group date timepicker" data-date="" data-date-format="hh:ii" data-link-field="end" data-link-format="hh:ii">
                    <input class="form-control" size="16" type="text" value="{!! isset($business_hour->end) ? date('H:i',strtotime($business_hour->end)) : '' !!}" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
				<input type="hidden" name="end" id="end" value="{!! isset($business_hour->end) ? date('H:i',strtotime($business_hour->end)) : '' !!}" /><br/>
			  </div>
			  {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Add'),['class' => 'btn btn-primary']) !!}