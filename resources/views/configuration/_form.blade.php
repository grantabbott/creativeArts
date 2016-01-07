			<div class="col-sm-6">
			  <div class="form-group">
			    {!! Form::label('company_name',trans('messages.Company Name'),[])!!}
				{!! Form::input('text','company_name',(config('config.company_name')) ? : '',['class'=>'form-control','placeholder'=>'Enter Company Name'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('contact_person',trans('messages.Contact Person'),[])!!}
				{!! Form::input('text','contact_person',(config('config.contact_person')) ? : '',['class'=>'form-control','placeholder'=>'Enter Contact Person'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('email',trans('messages.Email'),[])!!}
				{!! Form::input('email','email',(config('config.email')) ? : '',['class'=>'form-control','placeholder'=>'Enter Email'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('phone',trans('messages.Phone'),[])!!}
				{!! Form::input('number','phone',(config('config.phone')) ? : '',['class'=>'form-control','placeholder'=>'Enter Phone'])!!}
			  </div>
			</div>
			<div class="col-sm-6">
			  <div class="form-group">
			    {!! Form::label('city',trans('messages.City'),[])!!}
				{!! Form::input('text','city',(config('config.city')) ? : '',['class'=>'form-control','placeholder'=>'Enter City Name'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('state',trans('messages.State'),[])!!}
				{!! Form::input('text','state',(config('config.state')) ? : '',['class'=>'form-control','placeholder'=>'Enter State Name'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('zipcode',trans('messages.Zipcode'),[])!!}
				{!! Form::input('text','zipcode',(config('config.zipcode')) ? : '',['class'=>'form-control','placeholder'=>'Enter Zipcode'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('country_id',trans('messages.Country'),[])!!}
				{!! Form::select('country_id', [null=>'Please Select'] + $countries,(config('config.country_id')) ? : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Company'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('address',trans('messages.Address'),[])!!}
			    {!! Form::textarea('address',(config('config.address')) ? : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => 'Enter Address'])!!}
			  </div>
			  	{!! Form::hidden('config_type','general')!!}
			  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Save'),['class' => 'btn btn-primary']) !!}
			</div>
			<div class="clear"></div>