
			  <div class="form-group">
			    {!! Form::label('annoucement_title',trans('messages.Title'),[])!!}
				{!! Form::input('text','annoucement_title',isset($annoucement->annoucement_title) ? $annoucement->annoucement_title : '',['class'=>'form-control','placeholder'=>'Enter Title'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('start_date',trans('messages.Start Date'),[])!!}
				{!! Form::input('text','start_date',isset($annoucement->start_date) ? $annoucement->start_date : '',['class'=>'form-control datepicker-input','placeholder'=>'Enter Start Date','readonly' => 'true'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('end_date',trans('messages.End Date'),[])!!}
				{!! Form::input('text','end_date',isset($annoucement->end_date) ? $annoucement->end_date : '',['class'=>'form-control datepicker-input','placeholder'=>'Enter End Date','readonly' => 'true'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('role_id',trans('messages.Role'),['class' => 'control-label'])!!}
			    {!! Form::select('role_id[]', $roles, isset($selected_roles) ? $selected_roles : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Role','multiple' => true])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('annoucement_description',trans('messages.Description'),[])!!}
			    {!! Form::textarea('annoucement_description',isset($annoucement->annoucement_description) ? $annoucement->annoucement_description : '',['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Enter Content'])!!}
			  </div>
			  	{{ App\Classes\Helper::getCustomFields('annoucement-form',$custom_field_values) }}
			  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Save'),['class' => 'btn btn-primary']) !!}
