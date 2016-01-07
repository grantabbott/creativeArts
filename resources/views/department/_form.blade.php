
			  <div class="form-group">
			    {!! Form::label('department_name',trans('messages.Department Name'),[])!!}
				{!! Form::input('text','department_name',isset($department->department_name) ? $department->department_name : '',['class'=>'form-control','placeholder'=>'Enter Department Name'])!!}
			  </div>
			  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Add'),['class' => 'btn btn-primary']) !!}
